<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{

    // public function toggleLike(Request $request, Post $post)
    // {
    //     $user = Auth::user();

    //     $like = Like::where('user_id', $user->id)->where('post_id', $post->id)->first();

    //     if ($like) {
    //         $like->delete();
    //         $liked = false;
    //     } else {
    //         Like::create([
    //             'user_id' => $user->id,
    //             'post_id' => $post->id,
    //         ]);
    //         $liked = true;
    //     }

    //     return response()->json([
    //         'liked' => $liked,
    //         'message' => 'Like status toggled successfully.'
    //     ]);
    // }

}
