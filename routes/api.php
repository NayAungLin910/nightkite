<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// get some tags for welcome page
Route::get('/tags', [\App\Http\Controllers\Api\TagsContorller::class, "getTagsWelcomePage"]);

// search tags from welcome page
Route::post('/tags', [\App\Http\Controllers\Api\TagsContorller::class, "searchTagsWelcomePgae"]);

