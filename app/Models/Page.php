<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = ['slug', 'title', 'excerpt', 'content', 'image', 'meta_title', 'meta_description', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public static function findBySlug(string $slug): ?self
    {
        return static::where('slug', $slug)->where('is_active', true)->first();
    }
}
