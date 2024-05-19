<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Friend;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        // Fetch all posts with related data (user, comments, likes)
        // The global scope will automatically filter the posts
        $posts = Post::with('user', 'comments', 'likes')
            ->orderByDesc('id')
            ->paginate(10);

        return view('dashboard.pages.home.index', ['posts' => $posts]);
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
