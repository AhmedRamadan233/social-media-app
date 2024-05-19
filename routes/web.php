<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Frontend\CommentController;
use App\Http\Controllers\Frontend\FindFriendControler;
use App\Http\Controllers\Frontend\LikeController;
use App\Http\Controllers\Frontend\PostController;
use App\Http\Middleware\FriendRequestsCountMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});




Route::get('/register', [RegisterController::class, 'index'])->name('register.index');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.attempt');




Route::prefix('forgot-password')->group(function () {
    Route::get('/', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/send-to-mail', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    
    
    Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
});


Route::prefix('dashboard')->middleware(FriendRequestsCountMiddleware::class)->group(function (){
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
            Route::get('/requests-to-be-friend', [FindFriendControler::class, 'requestsToBeFriend'])->name('requests-to-be-friend');

        });

        Route::prefix('posts')->group(function () {
            Route::post('/', [PostController::class, 'store'])->name('posts.store');
            Route::post('/update/{id}', [PostController::class, 'update'])->name('posts.update');
            Route::delete('delete/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

        });
        Route::prefix('comments')->group(function () {
            Route::get('/{id}', [CommentController::class, 'getPostId'])->name('comments.get-post-id');
            Route::post('/store', [CommentController::class, 'store'])->name('comments.store');
        });
        Route::prefix('likes')->group(function () {
            Route::post('/toggle', [LikeController::class, 'toggleLike'])->name('likes.toggle');
        });
    });
});
