<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class StudentApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'date_of_birth',
        'nationality',
        'passport_number',
        'education_level',
        'desired_course',
        'desired_university',
        'target_country',
        'gpa',
        'english_test_type',
        'english_score',
        'personal_statement',
        'status',
        'admin_notes',
        'service_fee',
        'payment_status',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'gpa' => 'decimal:2',
        'english_score' => 'decimal:1',
        'service_fee' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function documents(): MorphMany
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    public function payments(): MorphMany
    {
        return $this->morphMany(Payment::class, 'payable');
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'yellow',
            'under_review' => 'blue',
            'approved' => 'green',
            'rejected' => 'red',
            'completed' => 'purple',
            default => 'gray',
        };
    }

    public function getPaymentStatusColorAttribute(): string
    {
        return match($this->payment_status) {
            'pending' => 'yellow',
            'paid' => 'green',
            'refunded' => 'red',
            default => 'gray',
        };
    }
}