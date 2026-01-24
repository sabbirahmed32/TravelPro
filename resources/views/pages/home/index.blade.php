@extends('layouts.app')

@section('title', 'Home - TravelPro')

@section('meta-description', 'Professional travel services including visa assistance, student admissions, tour packages, and consultation services. Your trusted travel partner.')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="hero-content fade-in">
                    <h1 class="display-4 fw-bold mb-4">Explore the World with Confidence</h1>
                    <p class="lead mb-4">Your trusted partner for visa services, student admissions, tour packages, and expert travel consultation.</p>
                    <div class="hero-buttons d-flex flex-wrap gap-3">
                        <a href="{{ url('/consultation') }}" class="btn btn-light btn-lg">
                            <i class="bi bi-telephone me-2"></i>Get Consultation
                        </a>
                        <a href="{{ url('/tours-holidays') }}" class="btn btn-outline-light btn-lg">
                            <i class="bi bi-airplane me-2"></i>Browse Tours
                        </a>
                    </div>
                    <div class="hero-stats mt-5">
                        <div class="row g-4">
                            <div class="col-4">
                                <div class="stat-item text-center">
                                    <h3 class="fw-bold">5000+</h3>
                                    <p>Happy Clients</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="stat-item text-center">
                                    <h3 class="fw-bold">50+</h3>
                                    <p>Destinations</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="stat-item text-center">
                                    <h3 class="fw-bold">10+</h3>
                                    <p>Years Experience</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-image text-center">
                    <img src="https://images.unsplash.com/photo-1469474968028-56623f02e42e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=874&q=80" 
                         alt="Travel" class="img-fluid rounded-4 shadow-lg">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="section-title">Our Services</h2>
                <p class="section-subtitle">Comprehensive travel solutions for all your needs</p>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="bi bi-passport"></i>
                    </div>
                    <h4>Visa Services</h4>
                    <p>Expert assistance for tourist, student, and work visa applications worldwide.</p>
                    <a href="{{ url('/visa-services') }}" class="btn btn-outline-primary btn-sm mt-3">Learn More</a>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="bi bi-mortarboard"></i>
                    </div>
                    <h4>Student Admission</h4>
                    <p>Complete guidance for university admissions and student visa processing.</p>
                    <a href="{{ url('/student-admission') }}" class="btn btn-outline-primary btn-sm mt-3">Learn More</a>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="bi bi-airplane"></i>
                    </div>
                    <h4>Tours & Holidays</h4>
                    <p>Exciting tour packages and holiday plans for unforgettable experiences.</p>
                    <a href="{{ url('/tours-holidays') }}" class="btn btn-outline-primary btn-sm mt-3">Learn More</a>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="bi bi-telephone"></i>
                    </div>
                    <h4>Consultation</h4>
                    <p>Professional travel consultation and personalized travel planning services.</p>
                    <a href="{{ url('/consultation') }}" class="btn btn-outline-primary btn-sm mt-3">Learn More</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Popular Destinations -->
<section class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="section-title">Popular Destinations</h2>
                <p class="section-subtitle">Explore our most sought-after travel destinations</p>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="card destination-card">
                    <img src="https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=870&q=80" 
                         class="card-img-top" alt="Dubai">
                    <div class="card-body">
                        <h5 class="card-title">Dubai, UAE</h5>
                        <p class="card-text">Experience luxury and innovation in the city of superlatives.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-primary fw-bold">From $1,299</span>
                            <a href="#" class="btn btn-primary btn-sm">Explore</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="card destination-card">
                    <img src="https://images.unsplash.com/photo-1512455039149-3cbb91b0b6f9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=870&q=80" 
                         class="card-img-top" alt="Singapore">
                    <div class="card-body">
                        <h5 class="card-title">Singapore</h5>
                        <p class="card-text">Discover the perfect blend of culture, cuisine, and modernity.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-primary fw-bold">From $999</span>
                            <a href="#" class="btn btn-primary btn-sm">Explore</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="card destination-card">
                    <img src="https://images.unsplash.com/photo-1519904981063-b0cf448d479e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=870&q=80" 
                         class="card-img-top" alt="Malaysia">
                    <div class="card-body">
                        <h5 class="card-title">Malaysia</h5>
                        <p class="card-text">Explore diverse landscapes and vibrant multicultural cities.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-primary fw-bold">From $799</span>
                            <a href="#" class="btn btn-primary btn-sm">Explore</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="section-title">What Our Clients Say</h2>
                <p class="section-subtitle">Real experiences from our valued customers</p>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="testimonial-card">
                    <div class="rating mb-3">
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                    </div>
                    <p class="mb-3">"Excellent service! They helped me get my student visa to Canada smoothly. The team was very professional and supportive throughout the process."</p>
                    <div class="d-flex align-items-center">
                        <img src="https://picsum.photos/seed/user1/50/50.jpg" alt="Client" class="rounded-circle me-3">
                        <div>
                            <h6 class="mb-0">Sarah Johnson</h6>
                            <small class="text-muted">Student Visa Client</small>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="testimonial-card">
                    <div class="rating mb-3">
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                    </div>
                    <p class="mb-3">"Amazing tour package to Dubai! Everything was well-organized from flights to hotels. Made our family vacation truly memorable."</p>
                    <div class="d-flex align-items-center">
                        <img src="https://picsum.photos/seed/user2/50/50.jpg" alt="Client" class="rounded-circle me-3">
                        <div>
                            <h6 class="mb-0">Michael Chen</h6>
                            <small class="text-muted">Tour Package Client</small>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="testimonial-card">
                    <div class="rating mb-3">
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                    </div>
                    <p class="mb-3">"Professional consultation service that helped me plan my business trip perfectly. Great attention to detail and personalized service."</p>
                    <div class="d-flex align-items-center">
                        <img src="https://picsum.photos/seed/user3/50/50.jpg" alt="Client" class="rounded-circle me-3">
                        <div>
                            <h6 class="mb-0">David Williams</h6>
                            <small class="text-muted">Business Consultation</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card border-0 shadow-lg" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <div class="card-body text-center text-white p-5">
                        <h2 class="mb-4">Ready to Start Your Journey?</h2>
                        <p class="lead mb-4">Get expert guidance and personalized travel solutions today</p>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="{{ url('/consultation') }}" class="btn btn-light btn-lg">
                                <i class="bi bi-telephone me-2"></i>Book Consultation
                            </a>
                            <a href="{{ url('/contact') }}" class="btn btn-outline-light btn-lg">
                                <i class="bi bi-envelope me-2"></i>Contact Us
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Latest Blog Posts -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="section-title">Latest from Our Blog</h2>
                <p class="section-subtitle">Travel tips, guides, and insights from our experts</p>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="card">
                    <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=870&q=80" 
                         class="card-img-top" alt="Blog Post">
                    <div class="card-body">
                        <div class="mb-2">
                            <span class="badge bg-primary">Travel Tips</span>
                            <small class="text-muted ms-2">2 days ago</small>
                        </div>
                        <h5 class="card-title">Top 10 Travel Destinations for 2024</h5>
                        <p class="card-text">Discover the most exciting places to visit in the coming year...</p>
                        <a href="{{ url('/blog/top-10-destinations-2024') }}" class="btn btn-outline-primary btn-sm">Read More</a>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="card">
                    <img src="https://images.unsplash.com/photo-1526494097098-586132821b0c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=870&q=80" 
                         class="card-img-top" alt="Blog Post">
                    <div class="card-body">
                        <div class="mb-2">
                            <span class="badge bg-success">Visa Guide</span>
                            <small class="text-muted ms-2">5 days ago</small>
                        </div>
                        <h5 class="card-title">Student Visa Application: Complete Guide</h5>
                        <p class="card-text">Everything you need to know about applying for a student visa...</p>
                        <a href="{{ url('/blog/student-visa-guide') }}" class="btn btn-outline-primary btn-sm">Read More</a>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="card">
                    <img src="https://images.unsplash.com/photo-1549188917-4e0a9c889244?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=870&q=80" 
                         class="card-img-top" alt="Blog Post">
                    <div class="card-body">
                        <div class="mb-2">
                            <span class="badge bg-warning text-dark">Holiday Packages</span>
                            <small class="text-muted ms-2">1 week ago</small>
                        </div>
                        <h5 class="card-title">Family Vacation Planning Made Easy</h5>
                        <p class="card-text">Tips and tricks for planning the perfect family holiday...</p>
                        <a href="{{ url('/blog/family-vacation-planning') }}" class="btn btn-outline-primary btn-sm">Read More</a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-4">
            <a href="{{ url('/blog') }}" class="btn btn-primary">View All Posts</a>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
// Add animation on scroll
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver(function(entries) {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('fade-in');
        }
    });
}, observerOptions);

// Observe all service cards and destination cards
document.querySelectorAll('.service-card, .destination-card, .testimonial-card').forEach(el => {
    observer.observe(el);
});
</script>
@endpush