<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FAQ extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'answer',
        'category',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    public function getCategoryLabelAttribute(): string
    {
        return match($this->category) {
            'visa' => 'Visa Services',
            'admission' => 'Student Admission',
            'travel' => 'Travel & Tours',
            'consultation' => 'Consultation',
            'general' => 'General',
            default => ucfirst($this->category),
        };
    }
}