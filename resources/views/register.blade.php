@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div style="max-width: 500px; margin: 50px auto;">
    <h1>Register</h1>
    
    <form method="POST" action="{{ route('register') }}">
        @csrf
        
        <div class="form-group">
            <label>Gender:</label><br>
            <label style="margin-right: 15px;">
                <input type="radio" name="gender" value="female" {{ old('gender') == 'female' ? 'checked' : '' }}> Female
            </label>
            <label>
                <input type="radio" name="gender" value="male" {{ old('gender') == 'male' ? 'checked' : '' }}> Male
            </label>
        </div>
        
        <div class="form-group">
            <label>Name:</label>
            <input type="text" name="name" value="{{ old('name') }}" required>
        </div>
        
        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
        </div>
        
        <div class="form-group">
            <label>Password:</label>
            <input type="password" name="password" required>
            <small>Min 8 characters with letters, numbers, and symbols</small>
        </div>
        
        <div class="form-group">
            <label>Confirm Password:</label>
            <input type="password" name="password_confirmation" required>
        </div>
        
        <button type="submit">Register</button>
    </form>
    
    <p style="margin-top: 20px; text-align: center;">
        Already have an account? <a href="{{ route('login.form') }}">Login here</a>
    </p>
</div>
@endsection