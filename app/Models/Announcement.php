<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = ['title', 'content', 'file', 'type', 'start_date', 'end_date', 'is_active', 'is_pinned'];
    protected $casts = ['start_date' => 'date', 'end_date' => 'date', 'is_active' => 'boolean', 'is_pinned' => 'boolean'];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('end_date')->orWhere('end_date', '>=', now());
            });
    }
}
