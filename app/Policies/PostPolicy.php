<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    // Autoriser la modification uniquement par le propriétaire
    public function update(User $user, Post $post)
    {
        return $user->id === $post->user_id;
    }

    // Autoriser la suppression uniquement par le propriétaire
    public function delete(User $user, Post $post)
    {
        return $user->id === $post->user_id;
    }
}
