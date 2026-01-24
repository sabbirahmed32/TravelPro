<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BookingPolicy
{
    public function view(User $user, Booking $booking): bool
    {
        return $user->isAdmin() || $booking->user_id === $user->id;
    }

    public function update(User $user, Booking $booking): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Booking $booking): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function cancel(User $user, Booking $booking): bool
    {
        return $user->isAdmin() || ($booking->user_id === $user->id && $booking->status !== 'completed');
    }
}