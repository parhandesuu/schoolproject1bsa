<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Extracurricular extends Model
{
    protected $fillable = ['name', 'description', 'image', 'schedule', 'teacher', 'order', 'is_active'];
    protected $casts = ['is_active' => 'boolean'];
    
    public function scopeActive($query) 
    { 
        return $query->where('is_active', true)->orderBy('order'); 
    }

    /**
     * Get matching FontAwesome icon class based on extracurricular name.
     */
    public function getIconAttribute(): string
    {
        $name = strtolower($this->name ?? '');

        if (str_contains($name, 'pramuka') || str_contains($name, 'scout') || str_contains($name, 'gudep')) {
            return 'fas fa-campground';
        }
        if (str_contains($name, 'osis')) {
            return 'fas fa-users-gear';
        }
        if (str_contains($name, 'paskib') || str_contains($name, 'bendera')) {
            return 'fas fa-flag';
        }
        if (str_contains($name, 'tari') || str_contains($name, 'dance')) {
            return 'fas fa-masks-theater';
        }
        if (str_contains($name, 'hadroh') || str_contains($name, 'rebana') || str_contains($name, 'rohis') || str_contains($name, 'marawis') || str_contains($name, 'mtq') || str_contains($name, 'islam')) {
            return 'fas fa-moon';
        }
        if (str_contains($name, 'marching') || str_contains($name, 'drumband') || str_contains($name, 'drum')) {
            return 'fas fa-drum';
        }
        if (str_contains($name, 'musik') || str_contains($name, 'gitar') || str_contains($name, 'band') || str_contains($name, 'angklung') || str_contains($name, 'kulintang')) {
            return 'fas fa-guitar';
        }
        if (str_contains($name, 'paduan') || str_contains($name, 'vokal') || str_contains($name, 'choir') || str_contains($name, 'singing')) {
            return 'fas fa-microphone-lines';
        }
        if (str_contains($name, 'basket')) {
            return 'fas fa-basketball';
        }
        if (str_contains($name, 'futsal') || str_contains($name, 'bola') || str_contains($name, 'sepak')) {
            return 'fas fa-futbol';
        }
        if (str_contains($name, 'voli') || str_contains($name, 'volley')) {
            return 'fas fa-volleyball';
        }
        if (str_contains($name, 'badminton') || str_contains($name, 'bulu tangkis') || str_contains($name, 'raket')) {
            return 'fas fa-table-tennis-paddle-ball';
        }
        if (str_contains($name, 'pmr') || str_contains($name, 'palang merah') || str_contains($name, 'uks') || str_contains($name, 'kesehatan')) {
            return 'fas fa-kit-medical';
        }
        if (str_contains($name, 'kir') || str_contains($name, 'ilmiah') || str_contains($name, 'sains') || str_contains($name, 'science')) {
            return 'fas fa-flask';
        }
        if (str_contains($name, 'robot') || str_contains($name, 'it') || str_contains($name, 'komputer') || str_contains($name, 'coding')) {
            return 'fas fa-robot';
        }
        if (str_contains($name, 'english') || str_contains($name, 'bahasa') || str_contains($name, 'club') || str_contains($name, 'speech')) {
            return 'fas fa-language';
        }
        if (str_contains($name, 'silat') || str_contains($name, 'karate') || str_contains($name, 'taekwondo') || str_contains($name, 'bela diri')) {
            return 'fas fa-hand-fist';
        }
        if (str_contains($name, 'jurnalistik') || str_contains($name, 'mading') || str_contains($name, 'penulis')) {
            return 'fas fa-newspaper';
        }
        if (str_contains($name, 'alam') || str_contains($name, 'sispala') || str_contains($name, 'lingkungan')) {
            return 'fas fa-mountain-sun';
        }
        if (str_contains($name, 'catur') || str_contains($name, 'chess')) {
            return 'fas fa-chess';
        }

        return 'fas fa-star';
    }

    /**
     * Get gradient background and text styling for icon container.
     */
    public function getIconThemeAttribute(): array
    {
        $name = strtolower($this->name ?? '');

        if (str_contains($name, 'pramuka') || str_contains($name, 'scout') || str_contains($name, 'gudep')) {
            return [
                'bg' => 'from-amber-100 to-orange-200',
                'icon_bg' => 'bg-amber-100',
                'text' => 'text-amber-800',
                'border' => 'border-amber-200',
                'badge' => 'Kepanduan'
            ];
        }
        if (str_contains($name, 'osis')) {
            return [
                'bg' => 'from-blue-100 to-indigo-200',
                'icon_bg' => 'bg-blue-100',
                'text' => 'text-blue-800',
                'border' => 'border-blue-200',
                'badge' => 'Organisasi'
            ];
        }
        if (str_contains($name, 'paskib') || str_contains($name, 'bendera')) {
            return [
                'bg' => 'from-red-100 to-rose-200',
                'icon_bg' => 'bg-red-100',
                'text' => 'text-red-800',
                'border' => 'border-red-200',
                'badge' => 'Kedisiplinan'
            ];
        }
        if (str_contains($name, 'tari') || str_contains($name, 'dance')) {
            return [
                'bg' => 'from-fuchsia-100 to-pink-200',
                'icon_bg' => 'bg-fuchsia-100',
                'text' => 'text-fuchsia-800',
                'border' => 'border-fuchsia-200',
                'badge' => 'Seni Tari'
            ];
        }
        if (str_contains($name, 'hadroh') || str_contains($name, 'rebana') || str_contains($name, 'rohis') || str_contains($name, 'islam')) {
            return [
                'bg' => 'from-emerald-100 to-teal-200',
                'icon_bg' => 'bg-emerald-100',
                'text' => 'text-emerald-800',
                'border' => 'border-emerald-200',
                'badge' => 'Seni Islami'
            ];
        }
        if (str_contains($name, 'marching') || str_contains($name, 'drumband') || str_contains($name, 'drum')) {
            return [
                'bg' => 'from-yellow-100 to-amber-200',
                'icon_bg' => 'bg-yellow-100',
                'text' => 'text-amber-800',
                'border' => 'border-yellow-200',
                'badge' => 'Musik Korps'
            ];
        }
        if (str_contains($name, 'musik') || str_contains($name, 'gitar') || str_contains($name, 'band')) {
            return [
                'bg' => 'from-purple-100 to-violet-200',
                'icon_bg' => 'bg-purple-100',
                'text' => 'text-purple-800',
                'border' => 'border-purple-200',
                'badge' => 'Seni Musik'
            ];
        }
        if (str_contains($name, 'paduan') || str_contains($name, 'vokal') || str_contains($name, 'choir')) {
            return [
                'bg' => 'from-pink-100 to-rose-200',
                'icon_bg' => 'bg-pink-100',
                'text' => 'text-pink-800',
                'border' => 'border-pink-200',
                'badge' => 'Vokal Musik'
            ];
        }
        if (str_contains($name, 'basket') || str_contains($name, 'futsal') || str_contains($name, 'bola') || str_contains($name, 'voli') || str_contains($name, 'badminton')) {
            return [
                'bg' => 'from-cyan-100 to-sky-200',
                'icon_bg' => 'bg-cyan-100',
                'text' => 'text-cyan-800',
                'border' => 'border-cyan-200',
                'badge' => 'Olahraga'
            ];
        }
        if (str_contains($name, 'pmr') || str_contains($name, 'kesehatan')) {
            return [
                'bg' => 'from-rose-100 to-red-200',
                'icon_bg' => 'bg-rose-100',
                'text' => 'text-red-800',
                'border' => 'border-rose-200',
                'badge' => 'Kemanusiaan'
            ];
        }
        if (str_contains($name, 'kir') || str_contains($name, 'sains') || str_contains($name, 'robot')) {
            return [
                'bg' => 'from-teal-100 to-cyan-200',
                'icon_bg' => 'bg-teal-100',
                'text' => 'text-teal-800',
                'border' => 'border-teal-200',
                'badge' => 'Sains & Teknologi'
            ];
        }

        return [
            'bg' => 'from-blue-100 to-indigo-200',
            'icon_bg' => 'bg-blue-100',
            'text' => 'text-blue-800',
            'border' => 'border-blue-200',
            'badge' => 'Ekstrakurikuler'
        ];
    }
}
