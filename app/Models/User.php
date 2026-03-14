<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Un user a plusieurs posts
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    

    // Un user a plusieurs likes
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}
