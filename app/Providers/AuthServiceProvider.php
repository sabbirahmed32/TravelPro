<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Policies\VisaApplicationPolicy;
use App\Policies\StudentApplicationPolicy;
use App\Policies\BookingPolicy;
use App\Policies\ConsultationPolicy;
use App\Policies\UserPolicy;
use App\Models\VisaApplication;
use App\Models\StudentApplication;
use App\Models\Booking;
use App\Models\Consultation;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        VisaApplication::class => VisaApplicationPolicy::class,
        StudentApplication::class => StudentApplicationPolicy::class,
        Booking::class => BookingPolicy::class,
        Consultation::class => ConsultationPolicy::class,
        User::class => UserPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        Gate::before(function (User $user, string $ability) {
            if ($user->isAdmin()) {
                return true;
            }
        });

        Gate::define('is-admin', function (User $user) {
            return $user->isAdmin();
        });

        Gate::define('manage-users', function (User $user) {
            return $user->isAdmin();
        });

        Gate::define('manage-content', function (User $user) {
            return $user->isAdmin();
        });

        Gate::define('view-analytics', function (User $user) {
            return $user->isAdmin();
        });
    }
}