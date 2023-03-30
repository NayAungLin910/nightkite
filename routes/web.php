<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;


// Routes for unauthorized user only
Route::middleware(['NotAuth'])->group(function () {
    // login get and post
    Route::view('/admin/login', 'auth.admin.login')->name('admin.login');
    Route::post('/admin/login', [\App\Http\Controllers\Auth\AdminAuthController::class, "postLogin"]);

    // register get and post
    Route::view('/admin/register', 'auth.admin.register')->name('admin.register');
    Route::post('/admin/register', [\App\Http\Controllers\Auth\AdminAuthController::class, "postRegister"]);
});

// Routes for both authorized and unauthorized users
// welcome page
Route::get('/', [\App\Http\Controllers\HomeController::class, "homePage"])->name('welcome');

// Articles
// view article
Route::get('/articles/{slug}', [\App\Http\Controllers\ArticleController::class, "viewArticle"])
    ->name('article.view');

// search article
Route::get('/articles/global/search', [\App\Http\Controllers\ArticleController::class, "globalSearchArticle"])
    ->name('article.search');

// author introuduction page
Route::get('/author/{id}', [\App\Http\Controllers\AuthorController::class, "viewAuthor"])->name('author.view');

// Routes only for authorized users
Route::prefix('admin')->middleware(['AuthUser'])->group(function () {
    // dashboard of authoried user
    Route::view('/dashboard', 'admin.admin-home')->name('admin.dashboard.home');

    // view profile
    Route::view('/dashboard/profile', 'admin.profile')->name('admin.dashboard.profile');

    // Routes for super admin only
    Route::middleware(['AuthAdmin'])->group(function () {
        // accept accounts 
        Route::get('/dashboard/accept-accounts', [\App\Http\Controllers\AdminAccountManagement::class, 'getAcceptAccounts'])
            ->name('admin.dashboard.accept-accounts');
        Route::post('/dashboard/accept-accounts', [\App\Http\Controllers\AdminAccountManagement::class, 'postAcceptAccount']);

        // decline account
        Route::post('/dashboard/decline-account', [\App\Http\Controllers\AdminAccountManagement::class, 'declineAccount'])
            ->name('admin.dashboard.decline-account');

        // delete the accepted admin account
        Route::post('/dashboard/delete-admin-account', [\App\Http\Controllers\AdminAccountManagement::class, 'deleteAdminAccount'])
            ->name('admin.dashboard.delete-admin-account');
    });

    // search accepted admins
    Route::get('/dashboard/search-account', [\App\Http\Controllers\AdminAccountManagement::class, "searchAdmin"])
        ->name('admin.dashboard.search-account');

    // Tags management
    // return create tag view
    Route::view('/dashboard/tags/create', 'admin.tags.create-tags')->name('admin.dashboard.create-tags');

    // create tag
    Route::post('/dashboard/tags/create', [\App\Http\Controllers\TagController::class, "postTag"]);

    // search tag
    Route::get('/dashboard/tags/get', [\App\Http\Controllers\TagController::class, "getTag"])
        ->name('admin.dashboard.get-tags');

    // delete tag
    Route::post('/dashboard/tags/delete', [\App\Http\Controllers\TagController::class, "deleteTag"])
        ->name('admin.dashboard.delete-tag');

    // show edit tag
    Route::get('/dashboard/tags/update/{slug}', [\App\Http\Controllers\TagController::class, "showUpdateTag"])
        ->name('admin.dashboard.update-tag');

    // post edit tag
    Route::post('/dashboard/tags/update/{slug}', [\App\Http\Controllers\TagController::class, "postUpdateTag"]);

    // Articles management
    // return the article create view
    Route::get('/dashboard/articles/create', [\App\Http\Controllers\ArticleController::class, "getArticleCreate"])
        ->name('admin.dashboard.create-article');

    // create article
    Route::post('/dashboard/articles/create', [\App\Http\Controllers\ArticleController::class, "postArticleCreate"]);

    // search article
    Route::get('/dashboard/articles/search', [\App\Http\Controllers\ArticleController::class, "getArticles"])
        ->name('admin.dashboard.search-article');

    // edit article
    Route::get('/dashboard/article/edit/{slug}', [\App\Http\Controllers\ArticleController::class, "editArticle"])
        ->name('admin.dashboard.edit-article');

    // post edit article
    Route::post('/dashboard/article/edit/{slug}', [\App\Http\Controllers\ArticleController::class, "postEditArticle"]);

    // delete article
    Route::post('/dashboard/article/delete', [\App\Http\Controllers\ArticleController::class, "deleteArticle"])
        ->name('admin.dashboard.delete-article');

    // logout route 
    Route::post('/logout', [\App\Http\Controllers\Auth\AdminAuthController::class, "postLogout"])->name('admin.logout');
});
