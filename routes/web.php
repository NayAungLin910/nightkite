<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

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
Route::view('/', 'welcome')->name('welcome');

// Routes only for authorized users
Route::prefix('admin')->middleware(['AuthUser'])->group(function () {
    // dashboard of authoried user
    Route::view('/dashboard', 'admin.admin-home')->name('admin.dashboard.home');

    // accept accounts
    Route::get('/dashboard/accept-accounts', [\App\Http\Controllers\AdminAccountManagement::class, 'getAcceptAccounts'])->name('admin.dashboard.accept-accounts');

    // logout route 
    Route::post('/logout', [\App\Http\Controllers\Auth\AdminAuthController::class, "postLogout"])->name('admin.logout');
});
