<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VisaApplicationController;
use App\Http\Controllers\StudentApplicationController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\TravelPackageController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\ContentController;

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::get('/me', [AuthController::class, 'me'])->middleware('auth:sanctum');
});

Route::get('/travel-packages', [TravelPackageController::class, 'index']);
Route::get('/travel-packages/{travelPackage}', [TravelPackageController::class, 'show']);

Route::get('/blogs', [ContentController::class, 'publishedBlogs']);
Route::get('/blogs/{blog}', [ContentController::class, 'showBlog']);

Route::get('/faqs', [ContentController::class, 'faqs']);

Route::middleware('auth:sanctum')->group(function () {
    
    Route::get('/dashboard', [DashboardController::class, 'index']);
    
    Route::get('/profile', [UserController::class, 'profile']);
    Route::put('/profile', [UserController::class, 'updateProfile']);
    Route::put('/password', [UserController::class, 'updatePassword']);
    
    Route::prefix('visa-applications')->group(function () {
        Route::get('/', [VisaApplicationController::class, 'index']);
        Route::post('/', [VisaApplicationController::class, 'store']);
        Route::get('/{visaApplication}', [VisaApplicationController::class, 'show']);
    });
    
    Route::prefix('student-applications')->group(function () {
        Route::get('/', [StudentApplicationController::class, 'index']);
        Route::post('/', [StudentApplicationController::class, 'store']);
        Route::get('/{studentApplication}', [StudentApplicationController::class, 'show']);
    });
    
    Route::prefix('bookings')->group(function () {
        Route::get('/', [BookingController::class, 'index']);
        Route::post('/', [BookingController::class, 'store']);
        Route::get('/{booking}', [BookingController::class, 'show']);
        Route::put('/{booking}/cancel', [BookingController::class, 'cancel']);
    });
    
    Route::prefix('consultations')->group(function () {
        Route::get('/', [ConsultationController::class, 'index']);
        Route::post('/', [ConsultationController::class, 'store']);
        Route::get('/{consultation}', [ConsultationController::class, 'show']);
        Route::put('/{consultation}/cancel', [ConsultationController::class, 'cancel']);
    });
    
    Route::middleware('admin')->prefix('admin')->group(function () {
        
        Route::get('/dashboard/analytics', [DashboardController::class, 'analytics']);
        
        Route::prefix('users')->group(function () {
            Route::get('/', [UserController::class, 'index']);
            Route::post('/', [UserController::class, 'store']);
            Route::get('/{user}', [UserController::class, 'show']);
            Route::put('/{user}', [UserController::class, 'update']);
            Route::delete('/{user}', [UserController::class, 'destroy']);
            Route::put('/{user}/toggle-status', [UserController::class, 'toggleStatus']);
        });
        
        Route::prefix('visa-applications')->group(function () {
            Route::put('/{visaApplication}', [VisaApplicationController::class, 'update']);
            Route::put('/{visaApplication}/status', [VisaApplicationController::class, 'updateStatus']);
        });
        
        Route::prefix('student-applications')->group(function () {
            Route::put('/{studentApplication}', [StudentApplicationController::class, 'update']);
            Route::put('/{studentApplication}/status', [StudentApplicationController::class, 'updateStatus']);
        });
        
        Route::prefix('travel-packages')->group(function () {
            Route::get('/', [TravelPackageController::class, 'adminIndex']);
            Route::post('/', [TravelPackageController::class, 'store']);
            Route::put('/{travelPackage}', [TravelPackageController::class, 'update']);
            Route::delete('/{travelPackage}', [TravelPackageController::class, 'destroy']);
            Route::put('/{travelPackage}/toggle-status', [TravelPackageController::class, 'toggleStatus']);
        });
        
        Route::prefix('bookings')->group(function () {
            Route::put('/{booking}', [BookingController::class, 'update']);
            Route::put('/{booking}/confirm', [BookingController::class, 'confirm']);
            Route::put('/{booking}/cancel', [BookingController::class, 'cancel']);
        });
        
        Route::prefix('consultations')->group(function () {
            Route::put('/{consultation}', [ConsultationController::class, 'update']);
            Route::put('/{consultation}/schedule', [ConsultationController::class, 'schedule']);
            Route::put('/{consultation}/complete', [ConsultationController::class, 'complete']);
            Route::put('/{consultation}/cancel', [ConsultationController::class, 'cancel']);
        });
        
        Route::prefix('content')->group(function () {
            Route::prefix('blogs')->group(function () {
                Route::get('/', [ContentController::class, 'blogs']);
                Route::post('/', [ContentController::class, 'storeBlog']);
                Route::put('/{blog}', [ContentController::class, 'updateBlog']);
                Route::delete('/{blog}', [ContentController::class, 'destroyBlog']);
            });
            
            Route::prefix('faqs')->group(function () {
                Route::get('/', [ContentController::class, 'adminFaqs']);
                Route::post('/', [ContentController::class, 'storeFaq']);
                Route::put('/{faq}', [ContentController::class, 'updateFaq']);
                Route::delete('/{faq}', [ContentController::class, 'destroyFaq']);
                Route::put('/{faq}/toggle-status', [ContentController::class, 'toggleFaqStatus']);
            });
        });
    });
});