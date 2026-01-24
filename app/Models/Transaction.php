<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_id',
        'user_id',
        'amount',
        'currency',
        'gateway',
        'gateway_transaction_id',
        'type',
        'status',
        'description',
        'gateway_response',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'gateway_response' => 'array',
    ];

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'completed' => 'green',
            'pending' => 'yellow',
            'failed' => 'red',
            'refunded' => 'purple',
            'cancelled' => 'gray',
            default => 'gray',
        };
    }

    public function getGatewayLabelAttribute(): string
    {
        return match($this->gateway) {
            'stripe' => 'Stripe',
            'paypal' => 'PayPal',
            'sslcommerz' => 'SSLCommerz',
            default => ucfirst($this->gateway),
        };
    }

    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'payment' => 'Payment',
            'refund' => 'Refund',
            'fee' => 'Fee',
            'adjustment' => 'Adjustment',
            default => ucfirst($this->type),
        };
    }
}