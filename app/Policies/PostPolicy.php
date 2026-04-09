<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    public function update(User $user, Post $post)
    {
        if ($user->id === $post->user_id) {
            return true;
        }

        if ($user->isAdmin() || $user->isSuperAdmin()) {
            return true;
        }

        return false;
    }

    public function delete(User $user, Post $post)
    {
        if ($user->id === $post->user_id) {
            return true;
        }

        if ($user->isAdmin() || $user->isSuperAdmin()) {
            return true;
        }

        return false;
    }
}