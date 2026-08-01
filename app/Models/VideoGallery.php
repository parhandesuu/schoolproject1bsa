<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoGallery extends Model
{
    protected $fillable = ['title', 'description', 'youtube_url', 'youtube_id', 'thumbnail', 'order', 'is_active'];
    protected $casts = ['is_active' => 'boolean'];

    public static function extractYoutubeId(string $url): string
    {
        preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $url, $matches);
        return $matches[1] ?? '';
    }

    public function getThumbnailUrlAttribute(): string
    {
        return $this->thumbnail
            ? asset('storage/' . $this->thumbnail)
            : "https://img.youtube.com/vi/{$this->youtube_id}/hqdefault.jpg";
    }
}
