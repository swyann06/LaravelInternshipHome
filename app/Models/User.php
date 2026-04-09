<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'gender', 'avatar', 'status', 'role_id',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function posts()
{
    return $this->hasMany(Post::class);
}

    public function isSuperAdmin()
{
    return $this->role_id === 1;
}

public function isAdmin()
{
    return $this->role_id === 3;
}

public function isUser()
{
    return $this->role_id === 2;
}

public function isBlocked(): bool
{
    return !$this->status;
}
}
