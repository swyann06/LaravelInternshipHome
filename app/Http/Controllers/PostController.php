<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $posts = Post::with('images', 'user')->latest()->get();
        return view('posts.index', compact('posts'));
    }

    public function store(StorePostRequest $request)
    {
        $post = auth()->user()->posts()->create([
            'content' => $request->input('content'),
        ]);

        if ($request->hasFile('images')) {
            foreach (array_slice($request->file('images'), 0, 10) as $file) {
                $post->images()->create([
                    'url' => $file->store('posts', 'public'),
                ]);
            }
        }

        return redirect()->back()->with('success', 'Post created successfully!');
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        return view('posts.edit', compact('post'));
    }

    public function update(StorePostRequest $request, Post $post)
    {
        $this->authorize('update', $post);
        
        // Fix: Update content
        $post->update([
            'content' => $request->input('content'),
        ]);

        if ($request->hasFile('images')) {
            foreach ($post->images as $image) {
                Storage::disk('public')->delete($image->url);
                $image->delete();
            }

            foreach ($request->file('images') as $file) {
                $post->images()->create([
                    'url' => $file->store('posts', 'public'),
                ]);
            }
        }

        return redirect()->route('posts.index')->with('success', 'Updated successfully');
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        foreach ($post->images as $image) {
            Storage::disk('public')->delete($image->url);
            $image->delete();
        }

        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Deleted successfully');
    }

    public function destroyImage($imageId)
    {
        $image = \App\Models\PostImage::findOrFail($imageId);
        $this->authorize('delete', $image->post);

        Storage::disk('public')->delete($image->url);
        $image->delete();

        return back()->with('success', 'Image deleted successfully');
    }
}