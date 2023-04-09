<?php

namespace App\Http\Controllers;

use App\Models\FeaturedTag;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Ramsey\Uuid\FeatureSet;

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
            "slug" => Str::slug(random_int(1000000000, 9999999999) . $request->name),
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
        $tags = Tag::query();

        /* select title similar to search */
        if ($request->search) {
            $tags = $tags->where('title', 'like', "%$request->search%");
        }

        /* select registration between startdate and enddate */
        if ($request->startdate && $request->enddate) {

            $startdate = Carbon::parse($request->startdate);
            $enddate = Carbon::parse($request->enddate);

            $tags = $tags->whereBetween('created_at', [$startdate, $enddate]);
        }

        /* orderby the admin list according to the selected timeline */
        if ($request->timeline && $request->timeline === "oldest") {
            $tags = $tags->oldest();
        } else {
            $tags = $tags->latest();
        }

        /* select according to who created the tag */
        if ($request->by) {
            if ($request->by === 'me') {
                $tags = $tags->where('user_id', Auth::user()->id);
            } elseif ($request->by === 'others') {
                $tags = $tags->whereNot(function ($query) {
                    $query->where('user_id', Auth::user()->id);
                });
            }
        }

        $tags = $tags->select('id', 'title', 'slug', 'created_at', 'user_id')->with('user:id,name,email', 'featuredTag')->withCount('articles')->paginate('10');

        return view('admin.tags.get-tags', compact('tags'));
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

        // if not super admin, check gate
        if (Auth::user()->role !== '3') {

            // only the admin who created the tag can delete it
            if (Gate::denies('delete-update-tag', $tag)) {
                return redirect()->back()->with('error', "Unauthorized action!");
            }
        }

        // delete tag
        $tagTitle = $tag->title;
        $tag->delete();

        return redirect()->back()->with('info', "Tag named $tagTitle has been deleted!");
    }

    // show update tag
    public function showUpdateTag($slug)
    {
        $tag = Tag::where('slug', $slug)->first();

        if (!$tag) {
            abort(404);
        }

        // if not super admin
        if (Auth::user()->role !== '3') {
            // only the admin who created the tag can delete it
            if (Gate::denies('delete-update-tag', $tag)) {
                return redirect()->back()->with('error', "Unauthorized action!");
            }
        }

        return view('admin.tags.update-tags', compact('tag'));
    }

    // handle post request to update tag
    public function postUpdateTag($slug, Request $request)
    {
        $request->validate([
            "name" => "required|string|min:3|max:150"
        ]);

        $tag = Tag::where('slug', $slug)->first();

        if (!$tag) {
            return redirect()->back()->with('error', "Tag Not Found!");
        }

        $request->validate([
            "name" => "unique:tags,title,$tag->id"
        ]);

        // if not super admin
        if (Auth::user()->role !== '3') {
            // only the admin who created the tag can delete it
            if (Gate::denies('delete-update-tag', $tag)) {
                return redirect()->back()->with('error', "Unauthorized action!");
            }
        }

        // save a new name
        $tag->title = $request->name;
        $tag->save();

        return redirect()->route('admin.dashboard.get-tags')->with('success', "A new name has been saved!");
    }

    /**
     * Feautre the tag
     */
    public function featuredTag(Request $request)
    {
        $request->validate([
            "slug" => "required|string"
        ]);

        $tag = Tag::with('featuredTag')->where('slug', $request->slug)->first();

        if (!$tag) {
            abort(404);
        }

        // if not super admin, check gate
        if (Auth::user()->role !== '3') {
            // only the admin who created the tag can delete it
            if (Gate::denies('delete-update-tag', $tag)) {
                return redirect()->back()->with('error', "Unauthorized action!");
            }
        }

        // if the tag is already featured, unfeature the tag
        if ($tag->featuredTag) {
            $unfeatureTag = FeaturedTag::where('tag_id', $tag->id)->first();
            $unfeatureTag->delete();

            return redirect()->back()->with('success', "The tag, $tag->title is now unfeatured!");
        }

        // checks if the total number of featured tags is or over 3, and if so, delete the oldest one
        if (FeaturedTag::get()->count() >= 3) {
            $oldestFeaturedTag = FeaturedTag::oldest()->limit(1)->first();
            $oldestFeaturedTag->delete();
        }

        // create a new featured tag
        $featuredTag = FeaturedTag::create([
            "slug" => Str::slug(random_int(1000000000, 9999999999) . $tag->title),
            "tag_id" => $tag->id
        ]);

        if (!$featuredTag) {
            return redirect()->back()->with("error", "The tag, $tag->title featuring process failed!");
        }

        return redirect()->back()->with('success', "The tag, $tag->title is now featured!");
    }
}
