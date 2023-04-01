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
        $tags = Tag::limit('8')->get();

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
}
