<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = ['title', 'description', 'file', 'file_type', 'file_size', 'category', 'downloads', 'is_active'];
    protected $casts = ['is_active' => 'boolean'];

    public function incrementDownloads(): void { $this->increment('downloads'); }

    public function getFormattedSizeAttribute(): string
    {
        $bytes = $this->file_size;
        if ($bytes >= 1048576) return round($bytes / 1048576, 2) . ' MB';
        if ($bytes >= 1024) return round($bytes / 1024, 2) . ' KB';
        return $bytes . ' B';
    }
}
