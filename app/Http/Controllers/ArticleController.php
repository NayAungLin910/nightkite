<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Tag;
use App\Services\CategoryFilterService;
use App\Services\SummerImageUploadService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    /* get view to create article */
    public function getArticleCreate()
    {
        $tags = Tag::orderBy('title')->get();
        return view('admin.articles.create-article', compact('tags'));
    }

    /* create article */
    public function postArticleCreate(Request $request)
    {
        $request->validate([
            "title" => "required|string",
            "meta_description" => "required|string",
            "description" => "required",
            "image" => "required|image|max:5000",
            "tags" => "required|exists:tags,id",
        ]);

        // upload the image
        $image = $request->file('image');
        $image_name = uniqid() . $image->getClientOriginalName();
        $image->move(public_path('/storage/images'), $image_name);

        // use SummerImageUploadService to transform and upload images inside the description
        $description = SummerImageUploadService::transformUpload($request->description);

        // create article
        $article = Article::create([
            'title' => $request->title,
            'slug' => Str::slug(uniqid() . $request->title),
            'meta_description' => $request->meta_description,
            'description' => $description,
            'user_id' => Auth::user()->id,
            'image' => '/storage/images/' . $image_name,
        ]);

        $article->tags()->sync($request->tags);

        return redirect()->back()->with('success', "A new article has been created!");
    }

    /* search articles */
    public function getArticles(Request $request)
    {
        $articles = Article::query();

        /* select title similar to search */
        if ($request->search) {
            $articles = $articles->where('title', 'like', "%$request->search%");
        }

        /* select registration between startdate and enddate */
        if ($request->startdate && $request->enddate) {

            $startdate = Carbon::parse($request->startdate);
            $enddate = Carbon::parse($request->enddate);

            $articles = $articles->whereBetween('created_at', [$startdate, $enddate]);
        }

        /* orderby the admin list according to the selected timeline */
        if ($request->timeline && $request->timeline === "oldest") {
            $articles = $articles->oldest();
        } else {
            $articles = $articles->latest();
        }

        /* select according to who created the article */
        if ($request->by) {
            if ($request->by === 'me') {
                $articles = $articles->where('user_id', Auth::user()->id);
            } elseif ($request->by === 'others') {
                $articles = $articles->whereNot(function ($query) {
                    $query->where('user_id', Auth::user()->id);
                });
            }
        }

        /* filter according to the selected tag */
        if ($request->tag) {
            $articles = $articles->whereHas('tags', fn ($q) => $q->where('tags.id', $request->tag));
        }

        $articles = $articles->select('id', 'title', 'slug', 'image', 'meta_description', 'user_id', 'created_at', 'updated_at')
            ->with('user:id,name,email', 'tags:id,title')
            ->paginate(10);

        $tags = Tag::orderBy('title')->get(); // for filter option

        return view('admin.articles.get-articles', compact('articles', 'tags'));
    }

    /* view article */
    public function viewArticle($slug)
    {
        $article = Article::where('slug', $slug)
            ->with('tags:id,slug,title', 'user:id,name,email,image')
            ->first();

        if (!$article) {
            return abort(404); // returns 404 status code
        }

        return view('admin.articles.view-article', compact('article'));
    }
}
