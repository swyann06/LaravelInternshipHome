@extends('layouts.app')

@section('title', 'Edit Post')

@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    <h1>Edit Post #{{ $post->id }}</h1>
    
    <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label>Content:</label>
            <textarea name="content" rows="5" style="width: 100%; padding: 8px;">{{ $post->content }}</textarea>
        </div>
        
        <div class="form-group">
            <label>Existing Images:</label><br>
            <div style="display: flex; gap: 10px; flex-wrap: wrap; margin-top: 10px;">
                @foreach($post->images as $image)
                    <div style="position: relative; display: inline-block;">
                        <img src="{{ asset('storage/' . $image->url) }}" style="width: 100px; height: 100px; object-fit: cover; border-radius: 5px;">
                        <button type="button"
                            onclick="event.preventDefault(); document.getElementById('delete-image-{{ $image->id }}').submit();"
                            style="position: absolute; top: -8px; right: -8px; background: red; color: white; border: none; border-radius: 50%; width: 25px; height: 25px; cursor: pointer;">
                            ×
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
        
        <div class="form-group">
            <label>Add More Images:</label>
            <input type="file" name="images[]" multiple accept="image/*">
            <small>Max 10 images total</small>
        </div>
        
        <button type="submit">Update Post</button>
        <a href="{{ route('posts.index') }}" class="btn btn-warning">Cancel</a>
    </form>
    
    @foreach($post->images as $image)
        <form id="delete-image-{{ $image->id }}" action="{{ route('posts.image.destroy', $image->id) }}" method="POST" style="display:none;">
            @csrf
            @method('DELETE')
        </form>
    @endforeach
</div>
@endsection