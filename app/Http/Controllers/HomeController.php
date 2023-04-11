<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\FeaturedTag;
use App\Models\Tag;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Shows the main page
     */
    public function homePage()
    {
        // the featured article
        $mainArticle = Article::where('feature', '1')
            ->select('title', 'image', 'slug', 'meta_description', 'id')
            ->first();

        $shownArticleIds = []; // the articles that are already included to be shown

        // get the featured tags along with the articles related to it
        $featuredTags = Tag::with('articles:id,slug,image,title')->whereHas('featuredTag')->get();

        if ($featuredTags) {
            foreach ($featuredTags as $featuredTag) {
                foreach ($featuredTag->articles as $article) {
                    // include the article id in the already shown article ids
                    $shownArticleIds[] = $article->id;
                }
            }
        }

        // latest articles
        $latestArticles = Article::where('feature', '0')
            ->select('title', 'image', 'slug', 'meta_description', 'id')
            ->latest()
            ->whereNotIn('id', $shownArticleIds)
            ->limit(4)
            ->get();

        return view('welcome', compact('mainArticle', 'latestArticles', 'featuredTags'));
    }
}
