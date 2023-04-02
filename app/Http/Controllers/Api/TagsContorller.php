<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagsContorller extends Controller
{
    /**
     * Tags to be shown on welcome page
     */
    public function getTagsWelcomePage()
    {
        $tags = Tag::withCount('articles')->orderBy('articles_count', 'desc')->limit('8')->get();

        if (!$tags) {
            return response()->json([
                "errors" => [
                    "tagsError" => "No tags found!"
                ]
            ], 422);
        }

        return response()->json([
            "data" => [
                "tags" => $tags
            ]
        ], 200);
    }

    /**
     * Handles post request of searching tag by
     * their name.
     */
    public function searchTagsWelcomePgae(Request $request)
    {
        $request->validate([
            "search" => "required|string"
        ]);

        $tags = Tag::where('title', 'like', "%$request->search%")->limit('8')->get();

        return response()->json([
            "data" => [
                "tags" => $tags
            ]
        ]);
    }
}
