<?php

namespace App\Http\Controllers;

use App\Models\Article;
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

        // health and fitness related articles
        $healthArticles = Article::whereHas('tags', fn ($q) => $q->whereIn('tags.title', ['Health & Fitness']))
            ->where('feature', '0')
            ->select('title', 'image', 'slug', 'meta_description', 'id')
            ->latest()
            ->limit(4)
            ->get();

        // ids that are already shown in a related section of the main page
        $shownIds = $healthArticles->pluck('id');

        // coding articles
        $codingArticles = Article::whereHas('tags', fn ($q) => $q->whereIn('tags.title', ['Coding']))
            ->where('feature', '0')
            ->whereNotIn('id', $shownIds)
            ->select('title', 'image', 'slug', 'meta_description', 'id')
            ->latest()
            ->limit(4)
            ->get();

        // add more shown ids to the shownIds
        foreach ($codingArticles as $ca) {
            $shownIds[] = $ca->id;
        }

        // latest articles
        $latestArticles = Article::where('feature', '0')
            ->select('title', 'image', 'slug', 'meta_description', 'id')
            ->latest()
            ->whereNotIn('id', $shownIds)
            ->limit(4)
            ->get();

        $healthTag = Tag::where('title', 'Health & Fitness')->first();
        $codingTag = Tag::where('title', 'Coding')->first();

        return view('welcome', compact('mainArticle', 'latestArticles', 'healthArticles', 'codingArticles', 'healthTag', 'codingTag'));
    }
}
