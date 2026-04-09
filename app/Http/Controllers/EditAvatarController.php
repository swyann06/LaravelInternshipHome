<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateAvatarRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EditAvatarController extends Controller
{
    public function edit()
    {
        return view('editAvatar', [
            'user' => Auth::user()
        ]);
    }

    public function update(UpdateAvatarRequest $request)
    {
        $user = Auth::user();

        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $path = $request->file('avatar')->store('avatars', 'public');

        $user->update([
            'avatar' => $path
        ]);

        return redirect()
            ->route('avatar.edit')
            ->with('success', 'Avatar updated!');
    }
}