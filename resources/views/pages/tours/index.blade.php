@extends('layouts.app')

@section('title', 'Tours & Holiday Packages - TravelPro')

@section('meta-description', 'Exciting tour packages and holiday plans for unforgettable travel experiences. Browse our curated tours worldwide.')

@section('content')
<!-- Hero Section -->
<section class="hero-section bg-primary text-white py-5 mb-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1 class="display-4 fw-bold mb-4">Tours & Holiday Packages</h1>
                <p class="lead">Discover amazing destinations with our curated tour packages</p>
            </div>
        </div>
    </div>
</section>

<!-- Travel Packages Section -->
<section class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="section-title mb-4">Available Tour Packages</h2>
            </div>
        </div>
        
        @if($packages->count() > 0)
        <div class="row g-4">
            @foreach($packages as $package)
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 shadow-sm">
                    @if($package->image)
                    <img src="{{ asset('storage/' . $package->image) }}" class="card-img-top" alt="{{ $package->title }}" style="height: 200px; object-fit: cover;">
                    @else
                    <img src="https://via.placeholder.com/400x200?text=No+Image" class="card-img-top" alt="{{ $package->title }}" style="height: 200px; object-fit: cover;">
                    @endif
                    
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $package->title }}</h5>
                        
                        <p class="text-muted small mb-2">
                            <i class="bi bi-geo-alt me-1"></i>{{ ucfirst($package->destination) }}
                        </p>
                        
                        <p class="card-text">{{ Str::limit($package->description, 100) }}</p>
                        
                        <div class="mb-3">
                            @if($package->start_date && $package->end_date)
                            <small class="text-muted">
                                <i class="bi bi-calendar me-1"></i>
                                {{ \Carbon\Carbon::parse($package->start_date)->format('M d, Y') }} - 
                                {{ \Carbon\Carbon::parse($package->end_date)->format('M d, Y') }}
                            </small>
                            @endif
                            <br>
                            <small class="text-muted">
                                <i class="bi bi-clock me-1"></i>{{ $package->duration_days }} days
                            </small>
                        </div>
                        
                        <div class="mt-auto">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="tour-price">
                                    <span class="h4 text-primary">${{ number_format($package->price, 2) }}</span>
                                    <small class="text-muted">/person</small>
                                </div>
                                <span class="badge bg-success">
                                    <i class="bi bi-check-circle me-1"></i>Available
                                </span>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <a href="#" class="btn btn-primary">
                                    <i class="bi bi-eye me-2"></i>View Details
                                </a>
                                <a href="{{ route('booking.create', $package) }}" class="btn btn-outline-primary">
                                    <i class="bi bi-calendar-check me-2"></i>Book Now
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-5">
            <div class="mb-4">
                <i class="bi bi-inbox display-1 text-muted"></i>
            </div>
            <h3 class="text-muted">No Tour Packages Available</h3>
            <p class="text-muted">We're currently updating our tour packages. Please check back soon!</p>
            <a href="{{ route('home') }}" class="btn btn-primary mt-3">
                <i class="bi bi-house me-2"></i>Back to Home
            </a>
        </div>
        @endif
    </div>
</section>

<!-- Features Section -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="section-title text-center mb-5">Why Choose Our Tours?</h2>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-3 col-md-6 text-center">
                <div class="feature-box">
                    <div class="feature-icon text-primary mb-3">
                        <i class="bi bi-shield-check display-4"></i>
                    </div>
                    <h5>Safe & Secure</h5>
                    <p class="text-muted">Your safety is our top priority with comprehensive travel insurance</p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 text-center">
                <div class="feature-box">
                    <div class="feature-icon text-primary mb-3">
                        <i class="bi bi-award display-4"></i>
                    </div>
                    <h5>Best Prices</h5>
                    <p class="text-muted">Competitive pricing with no hidden charges</p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 text-center">
                <div class="feature-box">
                    <div class="feature-icon text-primary mb-3">
                        <i class="bi bi-headset display-4"></i>
                    </div>
                    <h5>24/7 Support</h5>
                    <p class="text-muted">Round-the-clock assistance during your journey</p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 text-center">
                <div class="feature-box">
                    <div class="feature-icon text-primary mb-3">
                        <i class="bi bi-star display-4"></i>
                    </div>
                    <h5>Expert Guides</h5>
                    <p class="text-muted">Experienced local guides for authentic experiences</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
.tour-price {
    font-weight: bold;
}

.feature-box {
    padding: 20px;
    background: white;
    border-radius: 10px;
    box-shadow: 0 3px 15px rgba(0,0,0,0.1);
    height: 100%;
}

.card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
}

.hero-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.section-title {
    font-weight: 600;
    color: #333;
}
</style>
@endpush