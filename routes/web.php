<?php

use Illuminate\Support\Facades\Route;


/**
 * Routes for unauthorized user only
 */

Route::middleware(['NotAuth'])->prefix('admin')->as('admin.')->group(function () {
    // login get and post
    Route::view('/login', 'auth.admin.login')->name('login');
    Route::post('/login', [\App\Http\Controllers\Auth\AdminAuthController::class, "postLogin"]);

    // register get and post
    Route::view('/register', 'auth.admin.register')->name('register');
    Route::post('/register', [\App\Http\Controllers\Auth\AdminAuthController::class, "postRegister"]);
});

/**
 * Routes for both authorized and unauthorized users
 */

// welcome page
Route::get('/', [\App\Http\Controllers\HomeController::class, "homePage"])->name('welcome');

// view article
Route::get('/articles/{slug}', [\App\Http\Controllers\ArticleController::class, "viewArticle"])
    ->name('article.view');

// search article
Route::get('/articles/global/search', [\App\Http\Controllers\ArticleController::class, "globalSearchArticle"])
    ->name('article.search');

// author introuduction page
Route::get('/author/{id}', [\App\Http\Controllers\AuthorController::class, "viewAuthor"])->name('author.view');

// dynamic sitemap route
Route::get('sitemap.xml', [\App\Http\Controllers\SitemapController::class, "index"])->name('sitemap');

/**
 * Routes only for authorized users
 */

Route::prefix('admin/dashboard')->as('admin.dashboard.')->middleware(['AuthUser'])->group(function () {

    // view profile
    Route::view('profile', 'admin.profile')->name('profile');

    // update profile
    Route::get('profile/update', [\App\Http\Controllers\Auth\AdminAuthController::class, "updateProfile"])
        ->name('update-profile');
    Route::post('profile/update', [\App\Http\Controllers\Auth\AdminAuthController::class, "postUpdateProfile"]);

    // change password
    Route::view('profile/change-password', 'auth.admin.change-password')
        ->name('change-password');
    Route::post('profile/change-password', [\App\Http\Controllers\Auth\AdminAuthController::class, "changePassword"]);

    // Routes for super admin only
    Route::middleware(['AuthAdmin'])->group(function () {
        // accept accounts 
        Route::get('accept-accounts', [\App\Http\Controllers\AdminAccountManagement::class, 'getAcceptAccounts'])
            ->name('accept-accounts');
        Route::post('accept-accounts', [\App\Http\Controllers\AdminAccountManagement::class, 'postAcceptAccount']);

        // decline account
        Route::post('decline-account', [\App\Http\Controllers\AdminAccountManagement::class, 'declineAccount'])
            ->name('decline-account');

        // delete the accepted admin account
        Route::post('delete-admin-account', [\App\Http\Controllers\AdminAccountManagement::class, 'deleteAdminAccount'])
            ->name('delete-admin-account');
    });

    // search accepted admins
    Route::get('search-account', [\App\Http\Controllers\AdminAccountManagement::class, "searchAdmin"])
        ->name('search-account');

    // return create tag view
    Route::view('tags/create', 'admin.tags.create-tags')->name('create-tags');

    // create tag
    Route::post('tags/create', [\App\Http\Controllers\TagController::class, "postTag"]);

    // search tag
    Route::get('tags/get', [\App\Http\Controllers\TagController::class, "getTag"])
        ->name('get-tags');

    // delete tag
    Route::post('tags/delete', [\App\Http\Controllers\TagController::class, "deleteTag"])
        ->name('delete-tag');

    // show edit tag
    Route::get('tags/update/{slug}', [\App\Http\Controllers\TagController::class, "showUpdateTag"])
        ->name('update-tag');

    // post edit tag
    Route::post('tags/update/{slug}', [\App\Http\Controllers\TagController::class, "postUpdateTag"]);

    // feature tag
    Route::post('tags/feature', [\App\Http\Controllers\TagController::class, "featuredTag"])
        ->name('feature-tag');

    // Articles management
    // return the article create view
    Route::get('articles/create', [\App\Http\Controllers\ArticleController::class, "getArticleCreate"])
        ->name('create-article');

    // create article
    Route::post('articles/create', [\App\Http\Controllers\ArticleController::class, "postArticleCreate"]);

    // search article
    Route::get('articles/search', [\App\Http\Controllers\ArticleController::class, "getArticles"])
        ->name('search-article');

    // edit article
    Route::get('article/edit/{slug}', [\App\Http\Controllers\ArticleController::class, "editArticle"])
        ->name('edit-article');

    // post edit article
    Route::post('article/edit/{slug}', [\App\Http\Controllers\ArticleController::class, "postEditArticle"]);

    // delete article
    Route::post('article/delete', [\App\Http\Controllers\ArticleController::class, "deleteArticle"])
        ->name('delete-article');

    // logout route 
    Route::post('/logout', [\App\Http\Controllers\Auth\AdminAuthController::class, "postLogout"])
        ->name('logout');
});
