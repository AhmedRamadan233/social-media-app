<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
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
