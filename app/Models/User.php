<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'username',
        'name',
        'email',
        'password',
        'bio',
        'profile_image',
        'cover_image',
        'twitter_handle',
        'facebook_handle',
        'linkedin_handle',
        'website',
        'is_verified',
        'role',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_verified' => 'boolean',
        'is_admin' => 'boolean',
    ];

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function claps()
    {
        return $this->hasMany(Clap::class);
    }

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    public function subscription()
    {
        return $this->hasOne(Subscription::class);
    }
    public function followers()
    {
        return $this->hasMany(Follow::class, 'following_id');
    }

    public function following()
    {
        return $this->hasMany(Follow::class, 'follower_id');
    }

    public function isFollowing(User $user)
    {
        return $this->following()->where('following_id', $user->id)->exists();
    }

    public function getFullNameAttribute()
    {
        return $this->name;
    }

    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }
 
    public function isAdmin(): bool
    {
        // Option 1: If you have a 'role' column
        return $this->role === 'admin';

        // Option 2: If you have an 'is_admin' boolean column
        // return $this->is_admin === true;
    }
}