<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class SitemapController extends Controller
{
    public function index()
    {
        $articles = Article::select('id', 'slug')->get();

        return response()->view('sitemap', compact('articles'))->header('Content-Type', 'text/xml');
    }
}
