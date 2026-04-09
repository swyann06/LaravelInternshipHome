<!DOCTYPE html>
<html>
<head>
    <title>Users Management</title>
</head>
<body>

<h2>Users Management (SuperAdmin & Admin)</h2>

@if(session('success'))
    <p style="color:green;">{{ session('success') }}</p>
@endif

@if(session('error'))
    <p style="color:red;">{{ session('error') }}</p>
@endif

<form method="GET" action="{{ route('admin.users') }}">
    <input type="text" name="search" placeholder="Search by name or email" value="{{ request('search') }}">

    <select name="role">
        <option value="">All Roles</option>
        @foreach($roles as $role)
            <option value="{{ $role->id }}" @if(request('role') == $role->id) selected @endif>
                {{ ucfirst($role->name) }}
            </option>
        @endforeach
    </select>

    <button type="submit">Filter</button>
</form>

<table border="1" cellpadding="10" cellspacing="0">
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

            <td>{{ $user->role->name ?? 'N/A' }}</td>

            <td>
                @if($user->status)
                    <span style="color:green;">Active</span>
                @else
                    <span style="color:red;">Blocked</span>
                @endif
            </td>

            <td>
                @if(auth()->user()->isSuperAdmin() && $user->role->name !== 'superadmin')
                    <form method="POST" action="{{ route('admin.users.role', $user->id) }}">
                        @csrf

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
                @if(auth()->user()->isAdmin() || auth()->user()->isSuperAdmin())
                    @if(auth()->id() !== $user->id)

                        <form method="POST" action="{{ $user->status 
                            ? route('admin.users.block', $user->id) 
                            : route('admin.users.unblock', $user->id) }}">
                            
                            @csrf
                            @method('PATCH')

                            <button type="submit">
                                {{ $user->status ? 'Block' : 'Unblock' }}
                            </button>
                        </form>

                    @else
                        N/A
                    @endif
                @endif
            </td>

        </tr>
    @endforeach
    </tbody>
</table>

{{ $users->withQueryString()->links() }}

</body>
</html>