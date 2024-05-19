<?php

use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\FindFriendControler;
use App\Http\Controllers\Api\LikeController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('logout', [LoginController::class, 'logout']);

    Route::prefix('posts')->group(function () {
        Route::get('/', [PostController::class, 'index']);
        Route::post('/store', [PostController::class, 'store']);
        Route::put('/update/{id}', [PostController::class, 'update']);
        Route::delete('destroy/{post}', [PostController::class, 'destroy']);
    });
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit']);
        Route::post('/update', [ProfileController::class, 'update']);
    });

    Route::prefix('comments')->group(function () {
        Route::post('/store', [CommentController::class, 'store']);
    });
    Route::prefix('likes')->group(function () {
        Route::post('/toggle', [LikeController::class, 'toggleLike'])->name('likes.toggle');
    });

    Route::prefix('friends')->group(function () {
        Route::get('/', [FindFriendControler::class, 'index']);
        Route::post('/send-friend-request/{id}', [FindFriendControler::class, 'sendFriendRequest']);
        Route::post('/accept-friend-request/{id}', [FindFriendControler::class, 'acceptFriendRequest']);
        Route::post('/remove-friend-request/{id}', [FindFriendControler::class, 'removeFriendRequest']);
        Route::get('/all-friend', [FindFriendControler::class, 'allFriend']);
        Route::get('/requests-to-be-friend', [FindFriendControler::class, 'requestsToBeFriend']);

    });
});
