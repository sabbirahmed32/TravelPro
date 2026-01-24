<?php

namespace App\Policies;

use App\Models\VisaApplication;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class VisaApplicationPolicy
{
    public function view(User $user, VisaApplication $visaApplication): bool
    {
        return $user->isAdmin() || $visaApplication->user_id === $user->id;
    }

    public function update(User $user, VisaApplication $visaApplication): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, VisaApplication $visaApplication): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return true;
    }
}