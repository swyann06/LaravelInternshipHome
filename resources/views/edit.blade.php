<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile</title>
</head>
<body>

<form method="POST" action="{{ route('profile.update') }}">
    @csrf
        <input type="text" name="name" placeholder="name">
        <input type="email" name="email" placeholder="email">


    <button type="submit">Update</button>
</form>

</body>
</html>
