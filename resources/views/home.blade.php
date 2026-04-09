<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
</head>
<body>
<img src="{{ asset($user->avatar) }}" alt="User Avatar">
    <p>name: {{ $user->name }}</p>
    <p> email: {{ $user->email }}</p>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
    <a href="{{ route('avatar.edit') }}">Edit Avatar</a>
    <a href="{{ route('profile.edit') }}">Edit Profile</a>
    <a href="{{ route('password.edit') }}">Edit Password</a>

</body>
</html>
