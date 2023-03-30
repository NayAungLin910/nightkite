<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Return the author information along with the
     * articles written by him or her.
     */
    public function viewAuthor($id)
    {
        $author = User::where('id', $id)->first();

        if (!$author) { // if the author does not exist
            abort(404);
        }

        $articles = Article::select('title', 'id', 'slug', 'image', 'meta_description', 'user_id')
            ->where('user_id', $author->id)
            ->paginate(9);

        return view('author-profile', compact('author', 'articles'));
    }
}
