<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CacheService
{
    protected $defaultTtl = 3600; // 1 hour
    protected $keyPrefix = 'travel_app_';

    /**
     * Get cached data or store if not exists
     */
    public function remember(string $key, callable $callback, int $ttl = null): mixed
    {
        $fullKey = $this->keyPrefix . $key;
        $ttl = $ttl ?? $this->defaultTtl;

        return Cache::remember($fullKey, $ttl, $callback);
    }

    /**
     * Get cached data or store forever
     */
    public function rememberForever(string $key, callable $callback): mixed
    {
        $fullKey = $this->keyPrefix . $key;
        return Cache::rememberForever($fullKey, $callback);
    }

    /**
     * Put data in cache
     */
    public function put(string $key, mixed $value, int $ttl = null): bool
    {
        $fullKey = $this->keyPrefix . $key;
        $ttl = $ttl ?? $this->defaultTtl;

        return Cache::put($fullKey, $value, $ttl);
    }

    /**
     * Get data from cache
     */
    public function get(string $key, mixed $default = null): mixed
    {
        $fullKey = $this->keyPrefix . $key;
        return Cache::get($fullKey, $default);
    }

    /**
     * Check if key exists in cache
     */
    public function has(string $key): bool
    {
        $fullKey = $this->keyPrefix . $key;
        return Cache::has($fullKey);
    }

    /**
     * Remove data from cache
     */
    public function forget(string $key): bool
    {
        $fullKey = $this->keyPrefix . $key;
        return Cache::forget($fullKey);
    }

    /**
     * Clear cache by pattern
     */
    public function clearPattern(string $pattern): int
    {
        $fullPattern = $this->keyPrefix . $pattern;
        return Cache::forget($fullPattern);
    }

    /**
     * Get application statistics with caching
     */
    public function getApplicationStats(): array
    {
        return $this->remember('app_stats', function () {
            return [
                'total_users' => DB::table('users')->count(),
                'total_visa_applications' => DB::table('visa_applications')->count(),
                'total_student_applications' => DB::table('student_applications')->count(),
                'total_bookings' => DB::table('bookings')->count(),
                'total_consultations' => DB::table('consultations')->count(),
                'total_revenue' => DB::table('payments')->where('status', 'completed')->sum('amount'),
                'this_month_revenue' => DB::table('payments')
                    ->where('status', 'completed')
                    ->whereMonth('created_at', Carbon::now()->month)
                    ->whereYear('created_at', Carbon::now()->year)
                    ->sum('amount'),
                'active_users' => DB::table('users')
                    ->whereDate('last_login_at', '>=', Carbon::now()->subDays(30))
                    ->count(),
            ];
        }, 300); // Cache for 5 minutes
    }

    /**
     * Get user's applications with caching
     */
    public function getUserApplications(int $userId, string $type = null): array
    {
        $cacheKey = "user_applications_{$userId}_" . ($type ?? 'all');
        
        return $this->remember($cacheKey, function () use ($userId, $type) {
            $query = DB::table('users')
                ->join('visa_applications', 'users.id', '=', 'visa_applications.user_id')
                ->where('users.id', $userId)
                ->select('visa_applications.*', 'visa_applications.created_at as application_date');

            if ($type === 'visa') {
                return $query->get()->toArray();
            }

            $query = DB::table('users')
                ->join('student_applications', 'users.id', '=', 'student_applications.user_id')
                ->where('users.id', $userId)
                ->select('student_applications.*', 'student_applications.created_at as application_date');

            if ($type === 'student') {
                return $query->get()->toArray();
            }

            // Return all applications
            return [
                'visa' => DB::table('visa_applications')->where('user_id', $userId)->get()->toArray(),
                'student' => DB::table('student_applications')->where('user_id', $userId)->get()->toArray(),
                'bookings' => DB::table('bookings')->where('user_id', $userId)->get()->toArray(),
                'consultations' => DB::table('consultations')->where('user_id', $userId)->get()->toArray(),
            ];
        }, 600); // Cache for 10 minutes
    }

    /**
     * Cache travel packages with availability
     */
    public function getTravelPackages(bool $withAvailability = false): array
    {
        $cacheKey = 'travel_packages_' . ($withAvailability ? 'with_availability' : 'basic');
        
        return $this->remember($cacheKey, function () use ($withAvailability) {
            $query = DB::table('travel_packages')
                ->select('*')
                ->where('is_active', true);

            if ($withAvailability) {
                $query->selectRaw('*, (max_travelers - booked_travelers) as available_slots');
            }

            return $query->orderBy('created_at', 'desc')->get()->toArray();
        }, 1800); // Cache for 30 minutes
    }

    /**
     * Cache popular destinations
     */
    public function getPopularDestinations(int $limit = 10): array
    {
        return $this->remember('popular_destinations_' . $limit, function () use ($limit) {
            return DB::table('visa_applications')
                ->select('destination_country', DB::raw('count(*) as count'))
                ->groupBy('destination_country')
                ->orderByDesc('count')
                ->limit($limit)
                ->get()
                ->toArray();
        }, 86400); // Cache for 24 hours
    }

    /**
     * Cache recent activities
     */
    public function getRecentActivities(int $userId = null, int $limit = 20): array
    {
        $cacheKey = 'recent_activities_' . ($userId ?? 'global') . '_' . $limit;
        
        return $this->remember($cacheKey, function () use ($userId, $limit) {
            $activities = [];

            if ($userId) {
                // User-specific activities
                $visaApps = DB::table('visa_applications')
                    ->where('user_id', $userId)
                    ->select('created_at', 'status', DB::raw("'visa_application' as type"), 'destination_country as detail')
                    ->latest()
                    ->limit($limit)
                    ->get();

                $studentApps = DB::table('student_applications')
                    ->where('user_id', $userId)
                    ->select('created_at', 'status', DB::raw("'student_application' as type"), 'desired_course as detail')
                    ->latest()
                    ->limit($limit)
                    ->get();

                $activities = $visaApps->merge($studentApps)->sortByDesc('created_at')->take($limit);
            } else {
                // Global activities
                $activities = DB::table('visa_applications')
                    ->select('created_at', 'status', DB::raw("'visa_application' as type"), 'destination_country as detail')
                    ->latest()
                    ->limit($limit)
                    ->get();
            }

            return $activities->toArray();
        }, 300); // Cache for 5 minutes
    }

    /**
     * Cache dashboard data for user
     */
    public function getUserDashboardData(int $userId): array
    {
        $cacheKey = "user_dashboard_{$userId}";
        
        return $this->remember($cacheKey, function () use ($userId) {
            return [
                'stats' => [
                    'pending_visa_applications' => DB::table('visa_applications')
                        ->where('user_id', $userId)
                        ->where('status', 'pending')
                        ->count(),
                    'pending_student_applications' => DB::table('student_applications')
                        ->where('user_id', $userId)
                        ->where('status', 'pending')
                        ->count(),
                    'pending_bookings' => DB::table('bookings')
                        ->where('user_id', $userId)
                        ->where('status', 'pending')
                        ->count(),
                    'pending_consultations' => DB::table('consultations')
                        ->where('user_id', $userId)
                        ->where('status', 'pending')
                        ->count(),
                ],
                'recent_applications' => DB::table('visa_applications')
                    ->where('user_id', $userId)
                    ->latest()
                    ->limit(5)
                    ->get()
                    ->toArray(),
            ];
        }, 600); // Cache for 10 minutes
    }

    /**
     * Cache payment methods
     */
    public function getPaymentMethods(): array
    {
        return $this->remember('payment_methods', function () {
            return [
                'stripe' => [
                    'enabled' => config('services.stripe.enabled', false),
                    'fee_percent' => config('services.stripe.fee_percent', 2.9),
                    'fee_fixed' => config('services.stripe.fee_fixed', 0.30),
                    'supported_currencies' => ['USD', 'EUR', 'GBP'],
                ],
                'paypal' => [
                    'enabled' => config('services.paypal.enabled', false),
                    'fee_percent' => config('services.paypal.fee_percent', 3.4),
                    'fee_fixed' => config('services.paypal.fee_fixed', 0.30),
                    'supported_currencies' => ['USD', 'EUR', 'GBP'],
                ],
                'sslcommerz' => [
                    'enabled' => config('services.sslcommerz.enabled', false),
                    'fee_percent' => config('services.sslcommerz.fee_percent', 3.0),
                    'fee_fixed' => config('services.sslcommerz.fee_fixed', 0),
                    'supported_currencies' => ['BDT', 'USD'],
                ],
            ];
        }, 86400); // Cache for 24 hours
    }

    /**
     * Warm up cache
     */
    public function warmUpCache(): void
    {
        // Pre-load commonly accessed data
        $this->getApplicationStats();
        $this->getTravelPackages(true);
        $this->getPopularDestinations();
        $this->getPaymentMethods();
        
        // Warm up cache for active users
        $activeUsers = DB::table('users')
            ->whereDate('last_login_at', '>=', Carbon::now()->subDays(7))
            ->pluck('id');

        foreach ($activeUsers as $userId) {
            $this->getUserDashboardData($userId);
        }
    }

    /**
     * Clear user-specific cache
     */
    public function clearUserCache(int $userId): void
    {
        $patterns = [
            "user_applications_{$userId}_*",
            "recent_activities_{$userId}_*",
            "user_dashboard_{$userId}",
        ];

        foreach ($patterns as $pattern) {
            $this->clearPattern($pattern);
        }
    }

    /**
     * Get cache statistics
     */
    public function getCacheStats(): array
    {
        $cacheDriver = config('cache.default');
        
        return [
            'driver' => $cacheDriver,
            'hits' => $this->getCacheHits(),
            'misses' => $this->getCacheMisses(),
            'ratio' => $this->getCacheRatio(),
            'memory_usage' => $this->getCacheMemoryUsage(),
        ];
    }

    /**
     * Get cache hits
     */
    protected function getCacheHits(): int
    {
        // Implementation depends on cache driver
        return 0;
    }

    /**
     * Get cache misses
     */
    protected function getCacheMisses(): int
    {
        // Implementation depends on cache driver
        return 0;
    }

    /**
     * Get cache hit ratio
     */
    protected function getCacheRatio(): float
    {
        $hits = $this->getCacheHits();
        $misses = $this->getCacheMisses();
        $total = $hits + $misses;
        
        return $total > 0 ? round(($hits / $total) * 100, 2) : 0;
    }

    /**
     * Get cache memory usage
     */
    protected function getCacheMemoryUsage(): array
    {
        // Implementation depends on cache driver
        return [
            'used' => 0,
            'available' => 0,
            'percentage' => 0,
        ];
    }

    /**
     * Optimize database queries for caching
     */
    public function optimizeQueries(): void
    {
        // Add database indexes for better performance
        DB::statement('CREATE INDEX IF NOT EXISTS idx_visa_applications_user_status ON visa_applications(user_id, status)');
        DB::statement('CREATE INDEX IF NOT EXISTS idx_student_applications_user_status ON student_applications(user_id, status)');
        DB::statement('CREATE INDEX IF NOT EXISTS idx_bookings_user_status ON bookings(user_id, status)');
        DB::statement('CREATE INDEX IF NOT EXISTS idx_consultations_user_status ON consultations(user_id, status)');
        DB::statement('CREATE INDEX IF NOT EXISTS idx_payments_user_status ON payments(user_id, status)');
        DB::statement('CREATE INDEX IF NOT EXISTS idx_documents_morph ON documents(documentable_type, documentable_id)');
    }

    /**
     * Clean up expired cache entries
     */
    public function cleanupExpiredCache(): int
    {
        // This would be implementation-specific based on cache driver
        $cleared = 0;
        
        // Example for file-based cache
        if (config('cache.default') === 'file') {
            $cachePath = config('cache.stores.file.path');
            $expiredFiles = glob($cachePath . '/*');
            
            foreach ($expiredFiles as $file) {
                if (is_file($file) && filemtime($file) < time() - 86400) {
                    unlink($file);
                    $cleared++;
                }
            }
        }
        
        return $cleared;
    }
}