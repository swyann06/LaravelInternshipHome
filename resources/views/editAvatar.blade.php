<!DOCTYPE html>
<html>
<head>
    <title>Edit Avatar</title>
</head>
<body>

@if (session('success'))
    <div style="color: green">{{ session('success') }}</div>
@endif

<form method="POST" action="{{ route('avatar.update') }}" enctype="multipart/form-data">
    @csrf
    <input type="file" name="avatar" accept="image/*" required>
    <button type="submit">Upload</button>
</form>

@if ($user->avatar)
    <img src="{{ $user->avatar }}" alt="Avatar" width="100">
@endif

</body>
</html>
