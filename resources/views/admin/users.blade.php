@extends('layouts.app')

@section('title', 'Admin Panel')

@section('content')
<div>
    <h1>Users Management</h1>
    
    {{-- Search and Filter --}}
    <form method="GET" action="{{ route('admin.users') }}" style="margin-bottom: 20px;">
        <div style="display: flex; gap: 10px;">
            <input type="text" name="search" placeholder="Search by name or email" value="{{ request('search') }}" style="flex: 1; padding: 8px;">
            
            <select name="role" style="padding: 8px;">
                <option value="">All Roles</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" @if(request('role') == $role->id) selected @endif>
                        {{ ucfirst($role->name) }}
                    </option>
                @endforeach
            </select>
            
            <button type="submit">Filter</button>
            <a href="{{ route('admin.users') }}" class="btn btn-warning">Reset</a>
        </div>
    </form>
    
    {{-- Users Table --}}
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Change Role</th>
                <th>Block / Unblock</th>
            </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ ucfirst($user->role->name ?? 'N/A') }}</td>
                <td>
                    @if($user->status)
                        <span style="color: green;">Active</span>
                    @else
                        <span style="color: red;">Blocked</span>
                    @endif
                </td>
                <td>
                    @if(auth()->user()->isSuperAdmin() && (!$user->role || $user->role->name !== 'superadmin'))
                        <form method="POST" action="{{ route('admin.users.update-role', $user->id) }}">
                            @csrf
                            @method('PUT')
                            <select name="role_id">
                                @foreach($roles as $role)
                                    @if($role->name !== 'superadmin')
                                        <option value="{{ $role->id }}" @if($user->role_id === $role->id) selected @endif>
                                            {{ ucfirst($role->name) }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            <button type="submit">Change</button>
                        </form>
                    @else
                        N/A
                    @endif
                </td>
                <td>
                    @if(auth()->user()->isSuperAdmin() && auth()->id() !== $user->id && (!$user->role || $user->role->name !== 'superadmin'))
                        @if($user->status)
                            <form method="POST" action="{{ route('admin.users.block', $user->id) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-danger">Block</button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('admin.users.unblock', $user->id) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-primary">Unblock</button>
                            </form>
                        @endif
                    @else
                        N/A
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    
    {{ $users->withQueryString()->links() }}
</div>
@endsection