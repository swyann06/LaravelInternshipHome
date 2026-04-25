@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div style="max-width: 600px; margin: 0 auto; text-align: center;">
    <h1>Welcome, {{ auth()->user()->name }}!</h1>
    
    @if(auth()->user()->avatar)
        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="User Avatar" style="width: 150px; height: 150px; object-fit: cover; border-radius: 50%; margin: 20px 0;">
    @endif
    
    <div style="margin: 20px 0;">
        <p><strong>Name:</strong> {{ auth()->user()->name }}</p>
        <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
        <p><strong>Role:</strong> {{ ucfirst(auth()->user()->role->name ?? 'User') }}</p>
        <p><strong>Status:</strong> {{ auth()->user()->status ? 'Active' : 'Blocked' }}</p>
    </div>
    
    <div style="margin-top: 30px;">
        <a href="{{ route('profile.edit') }}" class="btn btn-primary">Edit Profile</a>
        <a href="{{ route('avatar.edit') }}" class="btn btn-primary">Change Avatar</a>
        <a href="{{ route('password.edit') }}" class="btn btn-primary">Change Password</a>
        <a href="{{ route('posts.index') }}" class="btn btn-primary">View Posts</a>
    </div>
</div>
@endsection