<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TagController extends Controller
{
    // post method create tag
    public function postTag(Request $request)
    {
        $request->validate([
            "name" => "required|string|min:3|max:150|unique:tags,title",
        ]);

        // create a tag
        $tag = Tag::create([
            "title" => $request->name,
            "slug" => Str::slug(uniqid() . $request->name),
            "user_id" => Auth::user()->id,
        ]);

        //if tag creation failed
        if (!$tag) {
            return redirect()->back()->withErrors([
                "errors" => "Something went wrong!"
            ]);
        }

        return redirect()->back()->with('success', "Tag named $tag->title has been created!");
    }

    // get tags
    public function getTag(Request $request)
    {
        $search = "";
        $search = "";
        $reqStartDate = "";
        $reqEndDate = "";
        $timeline = $request->timeline ?? "latest";

        $tags = Tag::query();

        /* select title similar to search */
        if ($request->search) {
            $search = $request->search;
            $tags = $tags->where('title', 'like', "%$search%");
        }

        /* select registration between startdate and enddate */
        if ($request->startdate && $request->enddate) {

            $reqStartDate = $request->startdate;
            $reqEndDate = $request->enddate;

            $startdate = Carbon::parse($reqStartDate);
            $enddate = Carbon::parse($reqEndDate);

            $tags = $tags->whereBetween('created_at', [$startdate, $enddate]);
        }

        /* orderby the admin list according to the selected timeline */
        if ($timeline === "oldest") {
            $tags = $tags->oldest();
        } else {
            $tags = $tags->latest();
        }

        $tags = $tags->select('id', 'title', 'slug', 'created_at', 'user_id')->with('user:id,name,email')->withCount('articles')->paginate('10');

        return view('admin.tags.get-tags', compact('tags', 'search', 'reqStartDate', 'reqEndDate', 'timeline'));
    }

    // delete tag
    public function deleteTag(Request $request)
    {
        $request->validate([
            "slug" => "required|string|exists:tags,slug"
        ]);

        $tag = Tag::where('slug', $request->slug)->first();

        // if no tag is found send error
        if (!$tag) {
            return redirect()->back()->withErrors([
                "errors" => "Something went wrong!"
            ]);
        }

        // delete tag
        $tagTitle = $tag->title;
        $tag->delete();

        return redirect()->back()->with('info', "Tag named $tagTitle has been deleted!");
    }
}
