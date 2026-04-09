   <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile</title>
</head>
<body>

<form method="POST" action="{{ route('password.update') }}">
    @csrf
        <input type="password" name="password" placeholder="password">

    <button type="submit">Update</button>
</form>

</body>
</html>
     
        
        
        
        
        
        
        
