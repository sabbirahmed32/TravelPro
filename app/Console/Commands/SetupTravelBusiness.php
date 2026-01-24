<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class SetupTravelBusiness extends Command
{
    protected $signature = 'travel:setup';
    protected $description = 'Setup the Travel Business application with all configurations';

    public function handle()
    {
        $this->info('🚀 Setting up Travel Business Application...');
        
        // Run migrations
        $this->info('📊 Running database migrations...');
        Artisan::call('migrate', ['--force' => true]);
        $this->line(Artisan::output());

        // Seed admin user
        $this->info('👤 Creating admin and test users...');
        Artisan::call('db:seed', ['--class' => 'AdminUserSeeder']);
        $this->line(Artisan::output());

        // Seed sample data
        $this->info('📝 Seeding sample data...');
        Artisan::call('db:seed', ['--class' => 'SampleDataSeeder']);
        $this->line(Artisan::output());

        // Create storage link
        $this->info('🔗 Creating storage link...');
        Artisan::call('storage:link');
        $this->line(Artisan::output());

        // Clear caches
        $this->info('🧹 Clearing caches...');
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');

        $this->info('✅ Setup completed successfully!');
        $this->line('');
        $this->info('🔐 Default Login Credentials:');
        $this->line('Admin: admin@travelbiz.com / password');
        $this->line('User:  user@travelbiz.com / password');
        $this->line('');
        $this->info('🌐 Next steps:');
        $this->line('1. Run: php artisan serve');
        $this->line('2. Visit: http://localhost:8000');
        $this->line('3. Login with the credentials above');
        $this->line('');
        $this->info('📚 API Documentation:');
        $this->line('API endpoints are available at: /api');
        $this->line('D Dashboard: /dashboard');
    }
}