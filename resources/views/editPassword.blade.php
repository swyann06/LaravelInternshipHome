@extends('layouts.app')

@section('title', 'Change Password')

@section('content')
<div style="max-width: 500px; margin: 0 auto;">
    <h1>Change Password</h1>
    
    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label>Current Password:</label>
            <input type="password" name="current_password" required>
        </div>
        
        <div class="form-group">
            <label>New Password:</label>
            <input type="password" name="password" required>
            <small>Min 8 characters with letters, numbers, and symbols</small>
        </div>
        
        <div class="form-group">
            <label>Confirm New Password:</label>
            <input type="password" name="password_confirmation" required>
        </div>
        
        <button type="submit">Change Password</button>
    </form>
</div>
@endsection