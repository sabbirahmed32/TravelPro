<?php

namespace App\Policies;

use App\Models\StudentApplication;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class StudentApplicationPolicy
{
    public function view(User $user, StudentApplication $studentApplication): bool
    {
        return $user->isAdmin() || $studentApplication->user_id === $user->id;
    }

    public function update(User $user, StudentApplication $studentApplication): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, StudentApplication $studentApplication): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return true;
    }
}