@extends('layouts.app')

@section('title', 'About Us - TravelPro')

@section('meta-description', 'Learn about TravelPro - your trusted travel partner with 10+ years of experience in visa services, student admissions, and tour packages.')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1 class="display-4 fw-bold mb-4">About TravelPro</h1>
                <p class="lead">Your trusted partner in making travel dreams come true</p>
            </div>
        </div>
    </div>
</section>

<!-- About Content -->
<section class="section-padding">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="about-content">
                    <h2 class="section-title text-start">Our Story</h2>
                    <p class="mb-4">Founded in 2014, TravelPro has been dedicated to providing exceptional travel services to clients worldwide. With over a decade of experience, we have helped thousands of travelers achieve their dreams of exploring new destinations.</p>
                    
                    <p class="mb-4">Our team of experienced travel consultants understands the complexities of international travel and is committed to making the process seamless and stress-free for our clients.</p>
                    
                    <div class="row g-4 mb-4">
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <div class="icon-box me-3">
                                    <i class="bi bi-check-circle-fill text-success fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Licensed & Certified</h6>
                                    <small class="text-muted">Government approved</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <div class="icon-box me-3">
                                    <i class="bi bi-check-circle-fill text-success fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Expert Team</h6>
                                    <small class="text-muted">Professional consultants</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <div class="icon-box me-3">
                                    <i class="bi bi-check-circle-fill text-success fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">24/7 Support</h6>
                                    <small class="text-muted">Always here to help</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <div class="icon-box me-3">
                                    <i class="bi bi-check-circle-fill text-success fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Best Price</h6>
                                    <small class="text-muted">Competitive rates</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex gap-3">
                        <a href="{{ url('/consultation') }}" class="btn btn-primary">
                            <i class="bi bi-telephone me-2"></i>Get Consultation
                        </a>
                        <a href="{{ url('/contact') }}" class="btn btn-outline-primary">
                            <i class="bi bi-envelope me-2"></i>Contact Us
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-image">
                    <img src="https://images.unsplash.com/photo-1521791136064-7986c2920216?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=870&q=80" 
                         alt="About TravelPro" class="img-fluid rounded-4 shadow-lg">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Mission & Vision -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="text-center mb-3">
                            <div class="icon-box mx-auto">
                                <i class="bi bi-bullseye text-primary fs-1"></i>
                            </div>
                        </div>
                        <h3 class="text-center mb-3">Our Mission</h3>
                        <p class="text-center">To provide exceptional travel services that make international travel accessible, affordable, and enjoyable for everyone. We strive to be the most trusted travel partner by delivering personalized solutions and unmatched customer service.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="text-center mb-3">
                            <div class="icon-box mx-auto">
                                <i class="bi bi-eye text-primary fs-1"></i>
                            </div>
                        </div>
                        <h3 class="text-center mb-3">Our Vision</h3>
                        <p class="text-center">To become the leading travel services company globally, recognized for innovation, reliability, and customer satisfaction. We aim to bridge cultures and create meaningful travel experiences that transform lives.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Core Values -->
<section class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="section-title">Our Core Values</h2>
                <p class="section-subtitle">The principles that guide everything we do</p>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="text-center">
                    <div class="value-icon mb-3">
                        <i class="bi bi-shield-check text-primary fs-1"></i>
                    </div>
                    <h5>Integrity</h5>
                    <p>We operate with honesty and transparency in all our dealings</p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="text-center">
                    <div class="value-icon mb-3">
                        <i class="bi bi-people text-primary fs-1"></i>
                    </div>
                    <h5>Customer Focus</h5>
                    <p>Our clients' needs are at the center of everything we do</p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="text-center">
                    <div class="value-icon mb-3">
                        <i class="bi bi-lightbulb text-primary fs-1"></i>
                    </div>
                    <h5>Innovation</h5>
                    <p>We continuously improve and adapt to changing market needs</p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="text-center">
                    <div class="value-icon mb-3">
                        <i class="bi bi-award text-primary fs-1"></i>
                    </div>
                    <h5>Excellence</h5>
                    <p>We strive for the highest standards in service delivery</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="section-title">Meet Our Team</h2>
                <p class="section-subtitle">The experts behind your travel success</p>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="card team-card">
                    <img src="https://picsum.photos/seed/ceo/300/300.jpg" class="card-img-top" alt="Team Member">
                    <div class="card-body text-center">
                        <h5 class="card-title">John Anderson</h5>
                        <p class="text-muted small">CEO & Founder</p>
                        <p class="card-text small">15+ years in travel industry</p>
                        <div class="social-links">
                            <a href="#" class="text-primary me-2"><i class="bi bi-linkedin"></i></a>
                            <a href="#" class="text-primary me-2"><i class="bi bi-twitter"></i></a>
                            <a href="#" class="text-primary"><i class="bi bi-envelope"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="card team-card">
                    <img src="https://picsum.photos/seed/manager/300/300.jpg" class="card-img-top" alt="Team Member">
                    <div class="card-body text-center">
                        <h5 class="card-title">Sarah Mitchell</h5>
                        <p class="text-muted small">Operations Manager</p>
                        <p class="card-text small">10+ years experience</p>
                        <div class="social-links">
                            <a href="#" class="text-primary me-2"><i class="bi bi-linkedin"></i></a>
                            <a href="#" class="text-primary me-2"><i class="bi bi-twitter"></i></a>
                            <a href="#" class="text-primary"><i class="bi bi-envelope"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="card team-card">
                    <img src="https://picsum.photos/seed/consultant/300/300.jpg" class="card-img-top" alt="Team Member">
                    <div class="card-body text-center">
                        <h5 class="card-title">Michael Chen</h5>
                        <p class="text-muted small">Senior Consultant</p>
                        <p class="card-text small">Visa specialist</p>
                        <div class="social-links">
                            <a href="#" class="text-primary me-2"><i class="bi bi-linkedin"></i></a>
                            <a href="#" class="text-primary me-2"><i class="bi bi-twitter"></i></a>
                            <a href="#" class="text-primary"><i class="bi bi-envelope"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="card team-card">
                    <img src="https://picsum.photos/seed/advisor/300/300.jpg" class="card-img-top" alt="Team Member">
                    <div class="card-body text-center">
                        <h5 class="card-title">Emily Rodriguez</h5>
                        <p class="text-muted small">Student Advisor</p>
                        <p class="card-text small">Education expert</p>
                        <div class="social-links">
                            <a href="#" class="text-primary me-2"><i class="bi bi-linkedin"></i></a>
                            <a href="#" class="text-primary me-2"><i class="bi bi-twitter"></i></a>
                            <a href="#" class="text-primary"><i class="bi bi-envelope"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Statistics -->
<section class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card border-0 shadow-lg" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <div class="card-body text-center text-white p-5">
                        <h2 class="mb-4">Our Achievements</h2>
                        <div class="row g-4">
                            <div class="col-lg-3 col-md-6">
                                <div class="stat-item">
                                    <h3 class="fw-bold display-4">5000+</h3>
                                    <p>Happy Clients</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="stat-item">
                                    <h3 class="fw-bold display-4">50+</h3>
                                    <p>Destinations</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="stat-item">
                                    <h3 class="fw-bold display-4">10+</h3>
                                    <p>Years Experience</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="stat-item">
                                    <h3 class="fw-bold display-4">98%</h3>
                                    <p>Success Rate</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-title">Ready to Start Your Journey?</h2>
                <p class="section-subtitle">Join thousands of satisfied clients who trust TravelPro</p>
                <div class="d-flex justify-content-center gap-3 mt-4">
                    <a href="{{ url('/consultation') }}" class="btn btn-primary btn-lg">
                        <i class="bi bi-telephone me-2"></i>Book Consultation
                    </a>
                    <a href="{{ url('/contact') }}" class="btn btn-outline-primary btn-lg">
                        <i class="bi bi-chat-dots me-2"></i>Get in Touch
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
.team-card {
    transition: all 0.3s ease;
    border: none;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
}

.team-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.15);
}

.value-icon {
    width: 80px;
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    background: rgba(37, 99, 235, 0.1);
    border-radius: 50%;
    transition: all 0.3s ease;
}

.value-icon:hover {
    background: var(--primary-color);
    color: white !important;
}

.value-icon:hover i {
    color: white !important;
}

.stat-item {
    padding: 20px;
}

.stat-item h3 {
    margin-bottom: 10px;
}

.social-links a {
    transition: all 0.3s ease;
}

.social-links a:hover {
    transform: scale(1.2);
}
</style>
@endpush

@push('scripts')
<script>
// Counter animation for statistics
function animateCounter(element, target, duration = 2000) {
    let start = 0;
    const increment = target / (duration / 16);
    
    const timer = setInterval(() => {
        start += increment;
        if (start >= target) {
            element.textContent = target + (element.textContent.includes('+') ? '+' : '') + (element.textContent.includes('%') ? '%' : '');
            clearInterval(timer);
        } else {
            element.textContent = Math.floor(start) + (element.textContent.includes('+') ? '+' : '') + (element.textContent.includes('%') ? '%' : '');
        }
    }, 16);
}

// Intersection Observer for counter animation
const counterObserver = new IntersectionObserver(function(entries) {
    entries.forEach(entry => {
        if (entry.isIntersecting && !entry.target.classList.contains('animated')) {
            const counters = entry.target.querySelectorAll('.stat-item h3');
            counters.forEach(counter => {
                const text = counter.textContent;
                const number = parseInt(text.replace(/\D/g, ''));
                animateCounter(counter, number);
            });
            entry.target.classList.add('animated');
        }
    });
}, { threshold: 0.5 });

// Observe the statistics section
document.querySelectorAll('.stat-item').forEach(el => {
    counterObserver.observe(el.parentElement);
});
</script>
@endpush