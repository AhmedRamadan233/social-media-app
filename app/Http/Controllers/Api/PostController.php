<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user', 'comments', 'likes')
            ->orderByDesc('id')
            ->paginate(10);

        return response()->json(['posts' => $posts]);
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'content' => 'required|string|max:255',
        ]);

        $post = Post::create([
            'content' => $validatedData['content'],
            'user_id' => Auth::id(),
        ]);

        return response()->json([
            'post' => $post,
            'message' => 'post created successfully.',
        ], 201);
    }


    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'content' => 'required|string|max:255',
        ]);
        $post = Post::findOrFail($id);
        $post->update([
            'content' => $validatedData['content'],
        ]);
        return response()->json([
            'post' => $post,
            'message' => 'Post updated successfully.',
        ], 200);
    }


    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json(['message' => 'Post deleted successfully']);
    }
}
