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

    // public function toggleLike(Request $request)
    // {
    //     $user_id = auth()->id();
    //     $post_id = $request->post_id;

    //     $like = Like::where('user_id', $user_id)->where('post_id', $post_id)->first();

    //     if ($like) {
    //         // Toggle the isLiked status
    //         $like->isLiked = !$like->isLiked;
    //         $like->save();
    //     } else {
    //         // Create a new like record
    //         Like::create([
    //             'user_id' => $user_id,
    //             'post_id' => $post_id,
    //             'isLiked' => true,
    //         ]);
    //     }

    //     return response()->json(['success' => true, 'isLiked' => $like ? $like->isLiked : true]);
    // }



    public function toggleLike(Request $request)
    {
        $user_id = auth()->id();
        $post_id = $request->post_id;

        $like = Like::where('user_id', $user_id)->where('post_id', $post_id)->first();

        if ($like) {
            // Delete the like if it exists
            $like->delete();
            $isLiked = false;
        } else {
            // Create a new like record
            Like::create([
                'user_id' => $user_id,
                'post_id' => $post_id,
                'isLiked' => true,
            ]);
            $isLiked = true;
        }

        return response()->json(['success' => true, 'isLiked' => $isLiked]);
    }
}
