<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'title',
        'description',
        'content',
        'icon',
        'image',
        'image_title',
        'file',
        'file_name',
        'images',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'images'    => 'array',
    ];

    public function scopeActive($query) { return $query->where('is_active', true)->orderBy('order'); }
}
