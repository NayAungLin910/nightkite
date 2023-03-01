<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Services\CategoryFilterService;
use App\Services\SummerImageUploadService;
use Illuminate\Http\Request;

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
        return $request->all();

        $request->validate([
            "title" => "required|string",
            "meta_description" => "required|string",
            "description" => "required",
            "image" => "required|image|max:5000",
            "tags" => "required",
        ]);

        

        // use SummerImageUploadService to transform and upload images inside the description
        $description = SummerImageUploadService::transformUpload($request->description);

        dd($description);
    }
}
