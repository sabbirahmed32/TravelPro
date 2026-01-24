<?php

namespace App\Policies;

use App\Models\Consultation;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ConsultationPolicy
{
    public function view(User $user, Consultation $consultation): bool
    {
        return $user->isAdmin() || $consultation->user_id === $user->id;
    }

    public function update(User $user, Consultation $consultation): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Consultation $consultation): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function cancel(User $user, Consultation $consultation): bool
    {
        return $user->isAdmin() || ($consultation->user_id === $user->id && $consultation->status !== 'completed');
    }
}