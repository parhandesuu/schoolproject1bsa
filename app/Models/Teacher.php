<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = ['name', 'nip', 'position', 'subject', 'education', 'photo', 'bio', 'type', 'order', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public function scopeActive($query) { return $query->where('is_active', true)->orderBy('order'); }
    public function scopeTeachers($query) { return $query->where('type', 'teacher'); }
    public function scopeStaff($query) { return $query->where('type', 'staff'); }
}
