<!DOCTYPE html>
<html>
<head>
    <title>Posts</title>
</head>
<body>

<h1>Create Post</h1>

@if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif

<form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="images[]" multiple required>
    <button type="submit" style="padding: 6px 12px;">Upload</button>
</form>

<hr>

<h1>All Posts</h1>

@foreach($posts as $post)
    <div class="post">
        <p><strong>Post ID:</strong> {{ $post->id }}</p>

        <div>
            @foreach($post->images as $img)
                <img src="{{ asset('storage/' . $img->url) }}" alt="Post Image">
            @endforeach
        </div>

        <div class="buttons">
            <a href="{{ route('posts.edit', $post) }}" class="edit-btn">Edit Post</a>

            <form action="{{ route('posts.destroy', $post) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="delete-btn">Delete Post</button>
            </form>
        </div>
    </div>
@endforeach

</body>
</html>