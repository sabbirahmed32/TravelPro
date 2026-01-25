<?php
 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VisaApplicationController;
use App\Http\Controllers\StudentApplicationController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SitemapController;

// Static Pages
Route::get('/', function () {
    return view('pages.home.index');
})->name('home');

Route::get('/about', function () {
    return view('pages.about.index');
})->name('about');

Route::get('/visa-services', function () {
    return view('pages.visa.index');
})->name('visa-services');

Route::get('/student-admission', function () {
    return view('pages.student.index');
})->name('student-admission');

Route::get('/tours-holidays', function () {
    return view('pages.tours.index');
})->name('tours-holidays');

Route::get('/consultation', function () {
    return view('pages.consultation.index');
})->name('consultation');

Route::get('/blog', function () {
    return view('pages.blog.index');
})->name('blog');

Route::get('/contact', function () {
    return view('pages.contact.index');
})->name('contact');

Route::get('/faq', function () {
    return view('pages.contact.faq');
})->name('faq');

Route::get('/privacy', function () {
    return view('pages.contact.privacy');
})->name('privacy');

Route::get('/terms', function () {
    return view('pages.contact.terms');
})->name('terms');

Route::get('/refund', function () {
    return view('pages.contact.refund');
})->name('refund');

// Authentication Routes
require __DIR__.'/auth.php';

// Dashboard Routes
Route::middleware(['auth'])->group(function () {
    // Main Dashboard Route
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    
    // User Dashboard Routes
    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        // User Dashboard Home
        Route::get('/user', [UserDashboardController::class, 'index'])->name('user');
        
        // Profile Management
        Route::get('/profile', [UserDashboardController::class, 'profile'])->name('profile');
        Route::patch('/profile', [UserDashboardController::class, 'updateProfile'])->name('profile.update');
        Route::patch('/password', [UserDashboardController::class, 'updatePassword'])->name('password.update');
        Route::post('/avatar', [UserDashboardController::class, 'uploadAvatar'])->name('avatar.upload');
        
        // User Routes
        Route::prefix('user')->name('user.')->group(function () {
            Route::get('/visa-applications', [UserDashboardController::class, 'visaApplications'])->name('visa-applications');
            Route::get('/student-applications', [UserDashboardController::class, 'studentApplications'])->name('student-applications');
            Route::get('/bookings', [UserDashboardController::class, 'bookings'])->name('bookings');
            Route::get('/consultations', [UserDashboardController::class, 'consultations'])->name('consultations');
            Route::get('/payments', [UserDashboardController::class, 'payments'])->name('payments');
            Route::get('/analytics', [UserDashboardController::class, 'analytics'])->name('analytics');
        });
    });
    
    // Admin Dashboard
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('index');
        Route::get('/analytics', [AdminDashboardController::class, 'analytics'])->name('analytics');
        Route::get('/quick-stats', [AdminDashboardController::class, 'quickStats'])->name('quick-stats');
        Route::get('/analytics/data', [AdminDashboardController::class, 'getAnalytics'])->name('analytics.data');
        
        // User Management
        Route::get('/users', [AdminDashboardController::class, 'manageUsers'])->name('users');
        Route::get('/users/create', [AdminDashboardController::class, 'createUser'])->name('users.create');
        Route::post('/users', [AdminDashboardController::class, 'storeUser'])->name('users.store');
        Route::get('/users/{user}/edit', [AdminDashboardController::class, 'editUser'])->name('users.edit');
        Route::patch('/users/{user}', [AdminDashboardController::class, 'updateUser'])->name('users.update');
        Route::delete('/users/{user}', [AdminDashboardController::class, 'deleteUser'])->name('users.delete');
        
        // Visa Applications
        Route::get('/visa-applications', [AdminDashboardController::class, 'manageVisaApplications'])->name('visa-applications');
        Route::get('/visa-applications/{visaApplication}', [AdminDashboardController::class, 'showVisaApplication'])->name('visa-applications.show');
        Route::post('/visa-applications/{visaApplication}/status', [VisaApplicationController::class, 'updateStatus'])->name('visa-applications.status');
        
        // Student Applications
        Route::get('/student-applications', [AdminDashboardController::class, 'manageStudentApplications'])->name('student-applications');
        Route::get('/student-applications/{studentApplication}', [AdminDashboardController::class, 'showStudentApplication'])->name('student-applications.show');
        Route::post('/student-applications/{studentApplication}/status', [StudentApplicationController::class, 'updateStatus'])->name('student-applications.status');
        
        // Bookings
        Route::get('/bookings', [AdminDashboardController::class, 'manageBookings'])->name('bookings');
        Route::get('/bookings/{booking}', [AdminDashboardController::class, 'showBooking'])->name('bookings.show');
        Route::post('/bookings/{booking}/confirm', [BookingController::class, 'confirm'])->name('bookings.confirm');
        
        // Consultations
        Route::get('/consultations', [AdminDashboardController::class, 'manageConsultations'])->name('consultations');
        Route::get('/consultations/{consultation}', [AdminDashboardController::class, 'showConsultation'])->name('consultations.show');
        Route::post('/consultations/{consultation}/schedule', [ConsultationController::class, 'schedule'])->name('consultations.schedule');
        Route::post('/consultations/{consultation}/complete', [ConsultationController::class, 'complete'])->name('consultations.complete');
        
        // Content Management
        Route::get('/blogs', [AdminDashboardController::class, 'manageBlogs'])->name('blogs');
        Route::get('/faqs', [AdminDashboardController::class, 'manageFAQs'])->name('faqs');
        Route::get('/travel-packages', [AdminDashboardController::class, 'manageTravelPackages'])->name('travel-packages');
    });
    
    // API Routes for AJAX
    Route::prefix('api')->name('api.')->group(function () {
        // Visa Applications
        Route::get('/visa-applications', [VisaApplicationController::class, 'index'])->name('api.visa-applications');
        Route::post('/visa-applications', [VisaApplicationController::class, 'store'])->name('api.visa-applications.store');
        Route::get('/visa-applications/{visaApplication}', [VisaApplicationController::class, 'show'])->name('api.visa-applications.show');
        Route::patch('/visa-applications/{visaApplication}', [VisaApplicationController::class, 'update'])->name('api.visa-applications.update');
        
        // Student Applications
        Route::get('/student-applications', [StudentApplicationController::class, 'index'])->name('api.student-applications');
        Route::post('/student-applications', [StudentApplicationController::class, 'store'])->name('api.student-applications.store');
        Route::get('/student-applications/{studentApplication}', [StudentApplicationController::class, 'show'])->name('api.student-applications.show');
        Route::patch('/student-applications/{studentApplication}', [StudentApplicationController::class, 'update'])->name('api.student-applications.update');
        
        // Bookings
        Route::get('/bookings', [BookingController::class, 'index'])->name('api.bookings');
        Route::post('/bookings', [BookingController::class, 'store'])->name('api.bookings.store');
        Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('api.bookings.show');
        Route::patch('/bookings/{booking}', [BookingController::class, 'update'])->name('api.bookings.update');
        Route::post('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('api.bookings.cancel');
        
        // Consultations
        Route::get('/consultations', [ConsultationController::class, 'index'])->name('api.consultations');
        Route::post('/consultations', [ConsultationController::class, 'store'])->name('api.consultations.store');
        Route::get('/consultations/{consultation}', [ConsultationController::class, 'show'])->name('api.consultations.show');
        Route::patch('/consultations/{consultation}', [ConsultationController::class, 'update'])->name('api.consultations.update');
        Route::post('/consultations/{consultation}/cancel', [ConsultationController::class, 'cancel'])->name('api.consultations.cancel');
        
        // File Upload Routes
        Route::post('/files/upload', [FileUploadController::class, 'upload'])->name('api.files.upload');
        Route::delete('/files/{document}', [FileUploadController::class, 'delete'])->name('api.files.delete');
        Route::get('/files/{document}/download', [FileUploadController::class, 'download'])->name('api.files.download');
        Route::get('/files/{document}/preview', [FileUploadController::class, 'preview'])->name('api.files.preview');
        Route::get('/files/{document}/info', [FileUploadController::class, 'fileInfo'])->name('api.files.info');
        Route::post('/avatar/upload', [FileUploadController::class, 'uploadAvatar'])->name('api.avatar.upload');
        
        // Payment Routes
        Route::get('/payment/checkout', [PaymentController::class, 'checkout'])->name('payment.checkout');
        Route::post('/payment/process', [PaymentController::class, 'process'])->name('payment.process');
        Route::get('/payment/sslcommerz/success', [PaymentController::class, 'sslcommerzSuccess'])->name('payment.sslcommerz.success');
        Route::get('/payment/sslcommerz/fail', [PaymentController::class, 'sslcommerzFail'])->name('payment.sslcommerz.fail');
        Route::get('/payment/sslcommerz/cancel', [PaymentController::class, 'sslcommerzCancel'])->name('payment.sslcommerz.cancel');
        Route::post('/payment/sslcommerz/ipn', [PaymentController::class, 'sslcommerzIPN'])->name('payment.sslcommerz.ipn');
        Route::get('/payment/paypal/success', [PaymentController::class, 'paypalSuccess'])->name('payment.paypal.success');
        Route::get('/payment/paypal/cancel', [PaymentController::class, 'paypalCancel'])->name('payment.paypal.cancel');
        Route::get('/payment/history', [PaymentController::class, 'history'])->name('payment.history');
        Route::get('/payment/{payment}', [PaymentController::class, 'show'])->name('payment.show');
        Route::post('/payment/{payment}/refund', [PaymentController::class, 'refund'])->name('payment.refund');
        Route::get('/secure/download/{token}', [FileUploadController::class, 'processSecureDownload'])->name('secure.download');
    });
});

// SEO Routes
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap.index');
Route::get('/sitemap/main.xml', [SitemapController::class, 'main'])->name('sitemap.main');
Route::get('/sitemap/travel-packages.xml', [SitemapController::class, 'travelPackages'])->name('sitemap.travel-packages');
Route::get('/sitemap/blog.xml', [SitemapController::class, 'blog'])->name('sitemap.blog');
Route::get('/sitemap.json', [SitemapController::class, 'json'])->name('sitemap.json');
Route::get('/robots.txt', [SitemapController::class, 'robots'])->name('robots.txt');
