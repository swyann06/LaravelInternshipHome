<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'My App')</title>
    <style>
        * { 
            margin: 0; 
            padding: 0; 
            box-sizing: border-box; 
        }
        
        body { 
            font-family: Arial, sans-serif; 
            line-height: 1.6; 
            background-color: #f4f4f4;
        }
        
        .container { 
            max-width: 1200px; 
            margin: 0 auto; 
            padding: 20px; 
        }
        
        /* Navigation Bar */
        nav { 
            background: #333; 
            color: #fff; 
            padding: 1rem; 
            margin-bottom: 2rem; 
        }
        
        nav .container { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
        }
        
        nav a { 
            color: #fff; 
            text-decoration: none; 
            margin-right: 15px; 
        }
        
        nav a:hover { 
            text-decoration: underline; 
        }
        
        nav button { 
            background: none; 
            border: none; 
            color: #fff; 
            cursor: pointer; 
            padding: 0; 
            font-size: 16px; 
        }
        
        nav button:hover { 
            text-decoration: underline; 
        }
        
        /* Alert Messages */
        .alert-success { 
            background: #d4edda; 
            color: #155724; 
            padding: 12px; 
            margin-bottom: 20px; 
            border-radius: 4px; 
            border-left: 4px solid #28a745;
        }
        
        .alert-error { 
            background: #f8d7da; 
            color: #721c24; 
            padding: 12px; 
            margin-bottom: 20px; 
            border-radius: 4px; 
            border-left: 4px solid #dc3545;
        }
        
        /* Post Cards */
        .post-card { 
            border: 1px solid #ddd; 
            margin-bottom: 20px; 
            padding: 15px; 
            border-radius: 5px; 
            background: #fff;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .post-images { 
            display: flex; 
            gap: 10px; 
            margin: 10px 0; 
            flex-wrap: wrap; 
        }
        
        .post-images img { 
            max-width: 150px; 
            max-height: 150px; 
            object-fit: cover; 
            border-radius: 5px;
        }
        
        /* Buttons */
        .btn { 
            display: inline-block; 
            padding: 5px 10px; 
            margin: 5px; 
            text-decoration: none; 
            border-radius: 3px; 
            border: none;
            cursor: pointer;
            font-size: 14px;
        }
        
        .btn-primary { 
            background: #007bff; 
            color: #fff; 
        }
        
        .btn-primary:hover { 
            background: #0056b3; 
        }
        
        .btn-danger { 
            background: #dc3545; 
            color: #fff; 
        }
        
        .btn-danger:hover { 
            background: #c82333; 
        }
        
        .btn-warning { 
            background: #ffc107; 
            color: #000; 
        }
        
        .btn-warning:hover { 
            background: #e0a800; 
        }
        
        .btn-sm { 
            padding: 3px 8px; 
            font-size: 12px; 
        }

        /* Pagination Styles */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 5px;
            margin: 20px 0;
            list-style: none;
            flex-wrap: wrap;
        }
        
        .pagination li {
            display: inline-block;
        }
        
        .pagination a, 
        .pagination span {
            padding: 8px 12px;
            border: 1px solid #ddd;
            color: #007bff;
            text-decoration: none;
            border-radius: 4px;
            transition: all 0.3s;
            display: inline-block;
            min-width: 36px;
            text-align: center;
        }
        
        .pagination a:hover {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }
        
        .pagination .active span {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }
        
        .pagination .disabled span {
            color: #999;
            cursor: not-allowed;
        }
        
        .pagination-info {
            text-align: center;
            margin-top: 10px;
            margin-bottom: 10px;
            color: #666;
            font-size: 14px;
        }
        
        /* Forms */
        .form-group { 
            margin-bottom: 15px; 
        }
        
        .form-group label { 
            display: block; 
            margin-bottom: 5px; 
            font-weight: bold; 
        }
        
        .form-group input, 
        .form-group select, 
        .form-group textarea { 
            width: 100%; 
            padding: 8px; 
            border: 1px solid #ddd; 
            border-radius: 4px; 
        }
        
        button[type="submit"] { 
            padding: 8px 15px; 
            background: #007bff; 
            color: #fff; 
            border: none; 
            border-radius: 3px; 
            cursor: pointer; 
        }
        
        button[type="submit"]:hover { 
            background: #0056b3; 
        }
        
        /* Tables */
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin: 20px 0; 
            background: #fff;
        }
        
        th, td { 
            border: 1px solid #ddd; 
            padding: 10px; 
            text-align: left; 
        }
        
        th { 
            background: #f4f4f4; 
            font-weight: bold;
        }
        
        tr:hover { 
            background: #f9f9f9; 
        }
        
        /* Error Messages */
        .error { 
            color: red; 
            font-size: 12px; 
            margin-top: 5px; 
        }
        
        /* Utilities */
        .text-center { text-align: center; }
        .mt-20 { margin-top: 20px; }
        .mb-20 { margin-bottom: 20px; }
    </style>
    @stack('styles')
</head>
<body>
    <nav>
        <div class="container">
            <div class="nav-brand">
                <a href="{{ url('/home') }}" style="font-weight: bold; font-size: 18px;">My App</a>
            </div>
            
            <div class="nav-links">
                @auth
                    <a href="{{ route('posts.index') }}">Posts</a>
                    <a href="{{ route('profile.edit') }}">Edit Profile</a>
                    <a href="{{ route('avatar.edit') }}">Change Avatar</a>
                    <a href="{{ route('password.edit') }}">Change Password</a>
                    
                    @if(auth()->user()->isSuperAdmin() || auth()->user()->isAdmin())
                        <a href="{{ route('admin.users') }}">Admin Panel</a>
                    @endif
                    
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login.form') }}">Login</a>
                    <a href="{{ route('register.form') }}">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container">
        @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert-error">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert-error">
                <ul style="margin-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>

    @stack('scripts')
</body>
</html>