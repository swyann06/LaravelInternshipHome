<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('edit', compact('user'));
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = Auth::user();
        $user->update($request->validated());

        return redirect()->route('profile.edit')->with('success', 'Profile updated!');
    }

    public function show()
    {
        return response()->json([
            'success' => true,
            'data' => auth()->user()->load('role'),
        ]);
    }
}