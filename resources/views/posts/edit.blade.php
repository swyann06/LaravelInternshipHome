<h1>Edit Post #{{ $post->id }}</h1>

@if(session('success'))
    <p style="color: green">{{ session('success') }}</p>
@endif

<form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <label>Existing Images:</label><br>

    @foreach($post->images as $image)
        <div style="display:inline-block; position:relative; margin:5px;">
            <img src="{{ asset('storage/' . $image->url) }}" width="100">

            <button type="button"
                onclick="event.preventDefault(); document.getElementById('delete-image-{{ $image->id }}').submit();"
                style="position:absolute; top:0; right:0; background:red; color:white;">
                X
            </button>
        </div>
    @endforeach

    <br><br>

    <label>Add More Images:</label><br>
    <input type="file" name="images[]" multiple>

    <br><br>
    <button type="submit">Update Post</button>
</form>

@foreach($post->images as $image)
    <form id="delete-image-{{ $image->id }}" action="{{ route('posts.image.destroy', $image) }}" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
    </form>
@endforeach

<a href="{{ route('posts.index') }}">Back to All Posts</a>