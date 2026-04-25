<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateUserRoleRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('register');
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        $role = Role::where('name', 'user')->firstOrFail();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'gender' => $data['gender'],
            'avatar' => $this->getDefaultAvatar($data['gender'], $data['name']),
            'role_id' => $role->id,
            'status' => true,
        ]);

        // Auto-login after registration
        Auth::login($user);

        return redirect()
            ->route('home')
            ->with('success', 'Registration successful! Welcome!');
    }

    private function getDefaultAvatar(string $gender, string $name): string
    {
        // Using UI Avatars as placeholder (no need for local files)
        $backgroundColor = $gender === 'male' ? '0D8F81' : 'f39c12';
        return 'https://ui-avatars.com/api/?background=' . $backgroundColor . '&color=fff&name=' . urlencode($name);
    }

    public function index()
    {
        $search = request()->query('search');
        $roleFilter = request()->query('role');

        $query = User::with('role');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($roleFilter) {
            $query->where('role_id', $roleFilter);
        }

        $users = $query->paginate(10)->withQueryString();
        $roles = Role::all();

        return view('admin.users', compact('users', 'roles', 'search', 'roleFilter'));
    }

    public function updateRole(UpdateUserRoleRequest $request, User $user)
    {
        $newRole = Role::findOrFail($request->role_id);

        if ($newRole->name === 'superadmin') {
            $exists = User::whereHas('role', function ($q) {
                $q->where('name', 'superadmin');
            })->where('id', '!=', $user->id)->exists();

            if ($exists) {
                return back()->with('error', 'Superadmin already exists.');
            }
        }

        if ($user->id === auth()->id() && $newRole->name !== 'superadmin') {
            return back()->with('error', 'You cannot remove your own superadmin role.');
        }

        $user->update(['role_id' => $request->role_id]);

        return back()->with('success', 'Role updated successfully.');
    }

    public function blockUser(User $user)
    {
        if ($user->isSuperAdmin()) {
            return back()->with('error', 'Cannot block superadmin.');
        }

        $user->update(['status' => false]);

        return back()->with('success', 'User blocked successfully.');
    }

    public function unblockUser(User $user)
    {
        $user->update(['status' => true]);

        return back()->with('success', 'User unblocked successfully.');
    }
}