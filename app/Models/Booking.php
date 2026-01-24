<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'travel_package_id',
        'booking_reference',
        'number_of_travelers',
        'traveler_details',
        'total_price',
        'paid_amount',
        'status',
        'special_requests',
        'admin_notes',
        'booking_date',
        'payment_due_date',
    ];

    protected $casts = [
        'traveler_details' => 'array',
        'total_price' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'booking_date' => 'datetime',
        'payment_due_date' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function travelPackage(): BelongsTo
    {
        return $this->belongsTo(TravelPackage::class);
    }

    public function payments(): MorphMany
    {
        return $this->morphMany(Payment::class, 'payable');
    }

    public function getOutstandingBalanceAttribute(): float
    {
        return max(0, $this->total_price - $this->paid_amount);
    }

    public function getIsFullyPaidAttribute(): bool
    {
        return $this->outstanding_balance <= 0;
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'yellow',
            'confirmed' => 'blue',
            'paid' => 'green',
            'cancelled' => 'red',
            'completed' => 'purple',
            default => 'gray',
        };
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            $booking->booking_reference = 'BK' . strtoupper(uniqid());
        });
    }
}