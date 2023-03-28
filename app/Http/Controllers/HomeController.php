<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Shows the main page
     */
    public function homePage()
    {
        $mainArticle = Article::where('feature', '1')
            ->select('title', 'image', 'slug', 'meta_description')
            ->first();

        return view('welcome', compact('mainArticle'));
    }
}
