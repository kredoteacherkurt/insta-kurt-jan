<?php

use App\Http\Controllers\Admin\UsersController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\Admin\PostsController;
use App\Http\Controllers\Admin\CategoriesController;
use Symfony\Component\HttpKernel\Profiler\Profile;

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
    return view('user.home');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    // home
    Route::get('/', [HomeController::class, 'index'])->name('index');
    // create post
    Route::get('/post/create', [PostController::class, 'create'])->name('posts.create');
    // store post
    Route::post('/post/store', [PostController::class, 'store'])->name('posts.store');
    // show post
    Route::get('/post/{id}/show', [PostController::class, 'show'])->name('posts.show');
    // edit post
    Route::get('/post/{id}/edit', [PostController::class, 'edit'])->name('posts.edit');
    // update post
    Route::patch('/post/{id}/update', [PostController::class, 'update'])->name('posts.update');
    // delete post
    Route::delete('/post/{id}/destroy', [PostController::class, 'destroy'])->name('posts.destroy');
    // store comment
    Route::post('/comment/{post_id}/store', [CommentController::class, 'store'])->name('comments.store');
    // delete comment
    Route::delete('/comment/{id}/destroy', [CommentController::class, 'destroy'])->name('comments.destroy');
    // profile show
    Route::get('/profile/{id}/show', [ProfileController::class, 'show'])->name('profile.show');
    // profile edit
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    // profile update
    Route::patch('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    // like
    Route::post('/like/{post_id}/store', [LikeController::class, 'store'])->name('like.store');
    // unlike
    Route::delete('/like/{post_id}/destroy', [LikeController::class, 'destroy'])->name('like.destroy');
    // follow
    Route::post('/follow/{user_id}/store', [FollowController::class, 'store'])->name('follow.store');
    // unfollow
    Route::delete('/follow/{user_id}/destroy', [FollowController::class, 'destroy'])->name('follow.destroy');
    // follower list
    Route::get('/profile/{id}/followers', [ProfileController::class, 'followers'])->name('profile.followers');
    // following list
    Route::get('/profile/{id}/following', [ProfileController::class, 'following'])->name('profile.following');
    // suggestion list
    Route::get('/suggestions', [HomeController::class, 'suggestions'])->name('suggestions');

    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
        Route::get('/users', [UsersController::class, 'index'])->name('users');
        Route::delete('/users/{id}/deactivate', [UsersController::class, 'deactivate'])->name('users.deactivate');
        Route::patch('/users/{id}/activate', [UsersController::class, 'activate'])->name('users.activate');

        Route::get('/posts', [PostsController::class, 'index'])->name('posts');
        Route::delete('/posts/{id}/hide', [PostsController::class, 'hide'])->name('posts.hide');
        Route::patch('/posts/{id}/unhide', [PostsController::class, 'unhide'])->name('posts.unhide');

        Route::get('/categories', [CategoriesController::class, 'index'])->name('categories');
        Route::post('/categories/store', [CategoriesController::class, 'store'])->name('categories.store');
        Route::patch('/categories/{id}/update', [CategoriesController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{id}/destroy', [CategoriesController::class, 'destroy'])->name('categories.destroy');
    });

    Route::group(['middleware' => 'auth'], function () {
        Route::get('/', [HomeController::class, 'index'])->name('index');
        Route::get('/people', [HomeController::class, 'search'])->name('search');
    });

    //update password
    Route::patch('/updatePassword', [ProfileController::class,'updatePassword'])->name('profile.updatePassword');

    //like
    Route::get('/likes/{post_id}/show', [LikeController::class, 'show'])->name('likes.show');
});
