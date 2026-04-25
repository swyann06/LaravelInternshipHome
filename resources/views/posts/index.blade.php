@extends('layouts.app')

@section('title', 'Posts')

@section('content')
<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px;">
    {{-- Left Column: All Posts --}}
    <div>
        <h1>All Posts</h1>
        
        @forelse($posts as $post)
            <div class="post-card">
                <p><strong>{{ $post->user->name }}</strong> 
                   <small style="color: #666;">({{ $post->created_at->diffForHumans() }})</small>
                </p>
                
                @if($post->content)
                    <p>{{ $post->content }}</p>
                @endif
                
                @if($post->images->count())
                    <div class="post-images">
                        @foreach($post->images as $img)
                            <img src="{{ asset('storage/' . $img->url) }}" alt="Post Image">
                        @endforeach
                    </div>
                @endif
                
                {{-- FIX: Show edit/delete ONLY for post owner or superadmin --}}
                @auth
                    @if(auth()->id() === $post->user_id || auth()->user()->isSuperAdmin())
                        <div style="margin-top: 10px;">
                            <a href="{{ route('posts.edit', $post) }}" class="btn btn-primary btn-sm">Edit Post</a>
                            
                            <form action="{{ route('posts.destroy', $post) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this post?')">Delete Post</button>
                            </form>
                        </div>
                    @endif
                @endauth
            </div>
        @empty
            <p>No posts yet.</p>
        @endforelse
    </div>
    
    {{-- Right Column: Create Post Form --}}
    <div>
        <div class="post-card">
            <h2>Create New Post</h2>
            
            <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="form-group">
                    <textarea name="content" rows="4" placeholder="What's on your mind?" style="width: 100%; padding: 8px;"></textarea>
                </div>
                
                <div class="form-group">
                    <input type="file" name="images[]" multiple accept="image/*">
                    <small>Max 10 images, 5MB each (jpg, png, webp)</small>
                </div>
                
                <button type="submit">Create Post</button>
            </form>
        </div>
    </div>
</div>
@endsection