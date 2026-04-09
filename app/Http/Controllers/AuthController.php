<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateUserRoleRequest;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('register');
    }

    public function register(RegisterRequest $request)
{
    $data = $request->validated();

    $roleId = Role::where('name', 'user')->value('id') ?? 2;

    try {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'gender' => $data['gender'],
            'avatar' => $this->getDefaultAvatar($data['gender']),
            'role_id' => $roleId,
            'status' => true,
        ]);
    } catch (\Exception $e) {
        return back()->with('error', 'Failed to register: ' . $e->getMessage());
    }

    return redirect()
        ->route('register.form')
        ->with('success', 'Registration successful!');
}

    private function getDefaultAvatar(string $gender): string
    {
        return $gender === 'male'
            ? 'storage/avatar/male.jpg'
            : 'storage/avatar/female.jpg';
    }

    public function index()
    {
        $this->authorizeSuperAdmin();

        $search = request()->query('search');
        $roleFilter = request()->query('role');

        $query = User::with('role');

        if ($search) {
            $query->where(function($q) use ($search) {
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
        $this->authorizeSuperAdmin();

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
        $this->authorizeAdminOrSuperAdmin($user);

        if ($user->isSuperAdmin()) {
            return back()->with('error', 'Cannot block superadmin.');
        }

        $user->update(['status' => false]);

        return back()->with('success', 'User blocked successfully.');
    }

    public function unblockUser(User $user)
    {
        $this->authorizeAdminOrSuperAdmin($user);

        $user->update(['status' => true]);

        return back()->with('success', 'User unblocked successfully.');
    }

    private function authorizeSuperAdmin()
    {
        if (!auth()->check() || !auth()->user()->isSuperAdmin()) {
            abort(403);
        }
    }

    private function authorizeAdminOrSuperAdmin(User $target)
    {
        $current = auth()->user();
        if (!$current->isAdmin() && !$current->isSuperAdmin()) {
            abort(403);
        }

        if ($target->isSuperAdmin() && !$current->isSuperAdmin()) {
            abort(403);
        }
    }
}