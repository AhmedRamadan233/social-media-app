<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Frontend\CommentController;
use App\Http\Controllers\Frontend\FindFriendControler;
use App\Http\Controllers\Frontend\LikeController;
use App\Http\Controllers\Frontend\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});




Route::get('/register', [RegisterController::class, 'index'])->name('register.index');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.attempt');



Route::prefix('dashboard')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::middleware(['auth'])->group(function () {
        Route::get('/', [PostController::class, 'index'])->name('dashboard.index');

        Route::prefix('profile')->group(function () {
            Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::post('/update', [ProfileController::class, 'update'])->name('profile.update');
        });
        Route::prefix('friends')->group(function () {
            Route::get('/', [FindFriendControler::class, 'index'])->name('friends.index');
            Route::post('/send-friend-request/{id}', [FindFriendControler::class, 'sendFriendRequest'])->name('send.friend.request');
            Route::post('/accept-friend-request/{id}', [FindFriendControler::class, 'acceptFriendRequest'])->name('accept.friend.request');
            Route::post('/remove-friend-request/{id}', [FindFriendControler::class, 'removeFriendRequest'])->name('remove.friend.request');
            Route::get('/all-friend', [FindFriendControler::class, 'allFriend'])->name('allFriend.index');
        });

        Route::prefix('posts')->group(function () {
            Route::post('/', [PostController::class, 'store'])->name('posts.store');
        });
        Route::prefix('comments')->group(function () {
            Route::get('/{id}', [CommentController::class, 'getPostId'])->name('comments.get-post-id');
            Route::post('/store', [CommentController::class, 'store'])->name('comments.store');
        });
        Route::prefix('likes')->group(function () {
            Route::post('/toggle-like/{postId}', [LikeController::class, 'toggleLike'])->name('toggle.like');
        });
    });
});
