@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div style="max-width: 500px; margin: 0 auto;">
    <h1>Edit Profile</h1>
    
    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label>Name:</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
        </div>
        
        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
        </div>
        
        <button type="submit">Update Profile</button>
        <a href="{{ route('home') }}" class="btn btn-warning">Cancel</a>
    </form>
</div>
@endsection