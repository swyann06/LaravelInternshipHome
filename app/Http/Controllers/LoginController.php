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
        return back()->withErrors([
            'email' => 'Your account is blocked. Please contact admin.',
        ])->withInput();
    }

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        return redirect()->intended('/home');
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ])->withInput();
}
    public function logout(\Illuminate\Http\Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/home');
    }
}