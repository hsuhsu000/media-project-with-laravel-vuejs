<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ListController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TrendPostController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    // Route::get('/dashboard', function () {
    //     return view('admin.profile.index');
    // })->name('dashboard');

    //admin
    Route::get('/dashboard', [ProfileController::class, 'index'])->name('dashboard');
    Route::post('admin/update', [
        ProfileController::class, 'updateAdminAccount'
    ])->name('admin#update');
    Route::get(
        'admin/changePassword',
        [ProfileController::class, 'directChangePassword']
    )->name('admin#directChangePassword');
    Route::post('admin/changePassword', [ProfileController::class, 'directChangePassword'])->name('admin#directChangePassword');

    //admin list
    Route::get('admin/list', [ListController::class, 'index'])->name('admin#list');
    Route::get('admin/delete/{id}', [ListController::class, 'deleteAccount'])->name('admin#deleteAccount');
    Route::post('admin/list', [ListController::class, 'adminListSearch'])->name('admin#ListSearch');

    //category
    Route::get('category', [CategoryController::class, 'index'])->name('admin#category');
    Route::post(
        'category/create',
        [
            CategoryController::class,
            'createCategory'
        ]
    )->name('admin#createCategory');
    Route::get(
        'category/delete/{id}',
        [CategoryController::class, 'deleteCategory']
    )->name('admin#deleteCategory');
    Route::post('category/search', [CategoryController::class, 'searchCategory'])->name('admin#searchCategory');
    Route::get('category/editPage/{id}', [CategoryController::class, 'categoryEditPage'])->name('admin#categoryEditPage');
    Route::post('category/update/{id}', [CategoryController::class, 'categoryUpdate'])->name('admin#categoryUpdate');

    //post
    Route::get(
        'post',
        [PostController::class, 'index']
    )->name('admin#post');
    Route::post(
        'admin/createPost',
        [PostController::class, 'createPost']
    )->name('admin#createPost');
    Route::get(
        'admin/deletePost/{id}',
        [PostController::class, 'deletePost']
    )->name('admin#deletePost');
    Route::get('admin/updatePostPage/{id}', [PostController::class, 'updatePostPage'])->name('admin#updatePostPage');
    Route::post('admin/updatePost/{id}', [PostController::class, 'updatePost'])->name('admin#updatePost');

    //trendpost
    Route::get('trendPost', [TrendPostController::class, 'index'])->name(
        'admin#trendPost'
    );
    Route::get('trendPost/details/{id}', [TrendPostController::class, 'trendPostDetails'])->name('admin#trendPostDetails');
});
