<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user', 'comments', 'likes')->orderByDesc('id')->paginate(10);

        return view('dashboard.pages.home.index', compact('posts'));
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
            'message' => 'Picture created successfully.',
        ], 201);
    }
}
