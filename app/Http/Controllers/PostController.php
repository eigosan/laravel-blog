<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PostController extends Controller
{
    /**
     * Show the application dashboard.
     */
    public function index(Request $request): View
    {
        return view('posts.index', [
            'posts' => Post::search($request->input('q'))
                ->with('author', 'likes')
                ->withCount('comments', 'thumbnail', 'likes')
                ->latest()
                ->paginate(20)
        ]);
    }

    /**
     * Show the form for creating a new post.
     */
    public function create(): View
    {
        return view('posts.create'); // Ensure this view exists at resources/views/posts/create.blade.php
    }

    /**
     * Store a newly created post in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate the request data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        // Create the post
        Post::create([
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
            'author_id' => auth()->id(),    
            'posted_at' => now(), // Set current timestamp
        ]);
        // Redirect to the posts index page with a success message
        return redirect()->route('posts.index')->with('success', 'Post created successfully!');
    }

    /**
     * Display the specified post.
     */
    public function show(Request $request, Post $post): View
    {
        $post->comments_count = $post->comments()->count();
        $post->likes_count = $post->likes()->count();

        return view('posts.show', [
            'post' => $post
        ]);
    }
}
