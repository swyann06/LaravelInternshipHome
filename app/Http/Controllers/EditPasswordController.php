<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePasswordRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EditPasswordController extends Controller
{
    public function edit()
    {
        return view('editPassword', [
            'user' => Auth::user()
        ]);
    }

    public function update(UpdatePasswordRequest $request)
{
    $data = $request->validated();

    Auth::user()->update([
        'password' => Hash::make($data['password']),
    ]);

    return redirect()
        ->route('home')
        ->with('success', 'Password updated successfully!');
}
}