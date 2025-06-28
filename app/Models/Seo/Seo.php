<?php

namespace App\Models\Seo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class Seo extends Authenticatable
{
    use  HasRoles,HasFactory, Notifiable, HasRoles;
    const ROLE_HEAD = 'seo-head';
    protected $guard_name = 'seo';

    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_image',
        'email_verified_at'
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function canManageTeam()
    {
        return $this->hasPermissionTo('seo manage team');
    }
    public function canInviteMembers()
    {
        return $this->hasPermissionTo('seo invite members');
    }
    public function getDisplayNameAttribute()
    {
        return $this->name ?: $this->email;
    }
    public function isHeadOrManager()
    {
        return $this->hasAnyRole([self::ROLE_HEAD, self::ROLE_MANAGER]);
    }
    public function hasSeoRole($role)
    {
        return $this->hasRole($role);
    }
    public function getSeoPermissions()
    {
        return $this->getAllPermissions()->pluck('name')->toArray();
    }
}
