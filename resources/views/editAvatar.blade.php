@extends('layouts.app')

@section('title', 'Edit Avatar')

@section('content')
<div style="max-width: 500px; margin: 0 auto;">
    <h1>Change Avatar</h1>
    
    @if($user->avatar)
        <div style="margin-bottom: 20px;">
            <label>Current Avatar:</label><br>
            <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" style="width: 150px; height: 150px; object-fit: cover; border-radius: 50%; margin-top: 10px;">
        </div>
    @endif
    
    <form method="POST" action="{{ route('avatar.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label>New Avatar:</label>
            <input type="file" name="avatar" accept="image/*" required>
            <small>Min 100x100px, Max 2MB (jpg, png, webp)</small>
        </div>
        
        <button type="submit">Upload Avatar</button>
    </form>
</div>
@endsection