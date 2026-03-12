<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title',
        'content',
        'user_id',
    ];

    // Un post appartient à un user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Un post a plusieurs likes
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // Vérifier si l'utilisateur connecté a liké ce post
    public function isLikedBy($userId)
    {
        return $this->likes()->where('user_id', $userId)->exists();
    }
}
