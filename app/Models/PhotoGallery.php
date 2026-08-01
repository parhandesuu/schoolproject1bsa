<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhotoGallery extends Model
{
    protected $fillable = ['photo_album_id', 'title', 'image', 'caption', 'order'];

    public function album()
    {
        return $this->belongsTo(PhotoAlbum::class, 'photo_album_id');
    }
}
