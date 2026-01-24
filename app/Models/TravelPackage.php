<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TravelPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'destination',
        'duration_days',
        'price',
        'discount_price',
        'image',
        'inclusions',
        'exclusions',
        'itinerary',
        'is_active',
        'max_travelers',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'inclusions' => 'array',
        'exclusions' => 'array',
        'is_active' => 'boolean',
        'max_travelers' => 'integer',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function getCurrentPriceAttribute(): float
    {
        return $this->discount_price ?? $this->price;
    }

    public function getDiscountPercentageAttribute(): ?float
    {
        if (!$this->discount_price) {
            return null;
        }

        return round((($this->price - $this->discount_price) / $this->price) * 100, 2);
    }

    public function getAvailableSlotsAttribute(): int
    {
        $bookedSlots = $this->bookings()->where('status', '!=', 'cancelled')->sum('number_of_travelers');
        return max(0, $this->max_travelers - $bookedSlots);
    }

    public function getIsSoldOutAttribute(): bool
    {
        return $this->available_slots <= 0;
    }
}