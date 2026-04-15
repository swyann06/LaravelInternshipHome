<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    private function canManage(User $user, Post $post): bool
    {
        return $user->id === $post->user_id
            || $user->isAdmin()
            || $user->isSuperAdmin();
    }

    public function update(User $user, Post $post): bool
    {
        return $this->canManage($user, $post);
    }

    public function delete(User $user, Post $post): bool
    {
        return $this->canManage($user, $post);
    }
}