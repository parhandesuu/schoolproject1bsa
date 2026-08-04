<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('admin') || $this->role === 'admin';
    }

    public function isEditor(): bool
    {
        return $this->hasRole('editor') || $this->role === 'editor';
    }

    public function isStaff(): bool
    {
        return $this->hasRole('staff') || $this->role === 'staff';
    }

    public function canAccessAdmin(): bool
    {
        return $this->hasAnyRole(['admin', 'editor', 'staff']) || in_array($this->role, ['admin', 'editor', 'staff']);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
