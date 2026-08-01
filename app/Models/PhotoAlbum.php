<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhotoAlbum extends Model
{
    protected $fillable = ['name', 'description', 'cover', 'is_active'];
    protected $casts = ['is_active' => 'boolean'];

    public function photos()
    {
        return $this->hasMany(PhotoGallery::class)->orderBy('order');
    }
}
