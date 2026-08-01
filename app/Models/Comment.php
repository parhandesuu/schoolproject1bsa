<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['post_id', 'name', 'email', 'content', 'status', 'ip_address'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function scopePending($query) { return $query->where('status', 'pending'); }
    public function scopeApproved($query) { return $query->where('status', 'approved'); }
}
