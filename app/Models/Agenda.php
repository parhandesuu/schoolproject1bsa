<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    protected $fillable = ['title', 'description', 'location', 'start_date', 'end_date', 'color', 'is_active'];
    protected $casts = ['start_date' => 'datetime', 'end_date' => 'datetime', 'is_active' => 'boolean'];

    public function scopeActive($query) { return $query->where('is_active', true); }
    public function scopeUpcoming($query) { return $query->where('start_date', '>=', now())->orderBy('start_date'); }
}
