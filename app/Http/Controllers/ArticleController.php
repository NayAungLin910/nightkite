<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Tag;
use App\Services\CategoryFilterService;
use App\Services\SummerImageUploadService;
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
}
