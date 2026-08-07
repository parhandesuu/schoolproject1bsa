<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'order',
        'code',
        'title',
        'question',
        'icon',
        'opt1_label',
        'opt2_label',
        'opt3_label',
        'opt4_label',
        'is_active',
    ];

    protected $casts = [
        'order'     => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Scope pertanyaan yang berstatus aktif.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope urutan pertanyaan.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('id');
    }

    /**
     * Format opsi jawaban (skala 4 ke 1).
     */
    public function getFormattedOptionsAttribute(): array
    {
        return [
            4 => [
                'label' => $this->opt4_label ?: 'Sangat Sesuai',
                'color' => 'emerald',
                'icon'  => 'far fa-grin-stars',
            ],
            3 => [
                'label' => $this->opt3_label ?: 'Sesuai',
                'color' => 'blue',
                'icon'  => 'far fa-smile',
            ],
            2 => [
                'label' => $this->opt2_label ?: 'Kurang Sesuai',
                'color' => 'amber',
                'icon'  => 'far fa-meh',
            ],
            1 => [
                'label' => $this->opt1_label ?: 'Tidak Sesuai',
                'color' => 'rose',
                'icon'  => 'far fa-frown',
            ],
        ];
    }
}
