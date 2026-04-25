<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(LoginRequest $request)
{
    $credentials = $request->validated();

    $user = \App\Models\User::where('email', $credentials['email'])->first();

    if ($user && $user->isBlocked()) {
        if ($request->wantsJson()) {
            return response()->json(['error' => 'Your account is blocked.'], 403);
        }
        return back()->withErrors(['email' => 'Your account is blocked.'])->withInput();
    }

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        
        // Create API token for Sanctum
        $token = $user->createToken('api-token')->plainTextToken;
        
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'user' => $user,
                'token' => $token,
                'redirect' => '/home'
            ]);
        }
        
        return redirect()->intended('/home');
    }

    if ($request->wantsJson()) {
        return response()->json(['error' => 'Invalid credentials.'], 401);
    }
    
    return back()->withErrors(['email' => 'Invalid credentials.'])->withInput();
}


    public function logout(\Illuminate\Http\Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}