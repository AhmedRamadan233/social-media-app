<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{

    // public function getPostId($id)
    // {
    //     $postId = Post::findOrFail($id);
    //     return response()->json(['postId' => $postId]);
    // }
    public function getPostId($id)
    {
        $postId = Post::findOrFail($id);

        $postContent = $postId->content;

        return response()->json(['postId' => $id , 'postContent'=>$postContent]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'content' => 'required|string|max:255',
            'post_id' => 'required|exists:posts,id', // Ensure that the post ID exists in the database
        ]);

        $comment = Comment::create([
            'content' => $validatedData['content'],
            'user_id' => Auth::id(),
            'post_id' => $validatedData['post_id'],
        ]);

        return response()->json([
            'comment' => $comment,
            'message' => 'Comment created successfully.',
        ], 201);
    }
    
    
}
