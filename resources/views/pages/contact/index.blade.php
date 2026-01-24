@extends('layouts.app')

@section('title', 'Contact Us - TravelPro')

@section('meta-description', 'Get in touch with TravelPro for expert travel services. Contact us for visa assistance, student admissions, tour packages, and consultation.')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1 class="display-4 fw-bold mb-4">Contact Us</h1>
                <p class="lead">We're here to help with all your travel needs</p>
            </div>
        </div>
    </div>
</section>

<!-- Contact Information & Form -->
<section class="section-padding">
    <div class="container">
        <div class="row">
            <!-- Contact Form -->
            <div class="col-lg-8">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">
                            <i class="bi bi-envelope me-2"></i>
                            Send us a Message
                        </h4>
                    </div>
                    <div class="card-body p-4">
                        <form id="contactForm">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Full Name *</label>
                                    <input type="text" class="form-control" name="full_name" required>
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label">Email Address *</label>
                                    <input type="email" class="form-control" name="email" required>
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label">Phone Number *</label>
                                    <input type="tel" class="form-control" name="phone" required>
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label">Subject *</label>
                                    <select class="form-select" name="subject" required>
                                        <option value="">Select Subject</option>
                                        <option value="visa_inquiry">Visa Services Inquiry</option>
                                        <option value="student_admission">Student Admission</option>
                                        <option value="tour_booking">Tour Package Booking</option>
                                        <option value="consultation">Consultation Services</option>
                                        <option value="general_inquiry">General Inquiry</option>
                                        <option value="feedback">Feedback & Suggestions</option>
                                        <option value="complaint">Complaint</option>
                                        <option value="partnership">Partnership Opportunities</option>
                                    </select>
                                </div>
                                
                                <div class="col-12">
                                    <label class="form-label">Message *</label>
                                    <textarea class="form-control" name="message" rows="5" required placeholder="Please provide detailed information about your inquiry..."></textarea>
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label">Preferred Contact Method</label>
                                    <select class="form-select" name="contact_method">
                                        <option value="email">Email</option>
                                        <option value="phone">Phone</option>
                                        <option value="whatsapp">WhatsApp</option>
                                        <option value="any">Any method</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label">Best Time to Contact</label>
                                    <select class="form-select" name="best_time">
                                        <option value="anytime">Anytime</option>
                                        <option value="morning">Morning (9AM-12PM)</option>
                                        <option value="afternoon">Afternoon (12PM-5PM)</option>
                                        <option value="evening">Evening (5PM-7PM)</option>
                                    </select>
                                </div>
                                
                                <div class="col-12">
                                    <label class="form-label">How did you hear about us?</label>
                                    <select class="form-select" name="referral_source">
                                        <option value="">Select Source</option>
                                        <option value="google">Google Search</option>
                                        <option value="facebook">Facebook</option>
                                        <option value="instagram">Instagram</option>
                                        <option value="linkedin">LinkedIn</option>
                                        <option value="youtube">YouTube</option>
                                        <option value="friend">Friend/Colleague</option>
                                        <option value="advertisement">Advertisement</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                                
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="newsletterCheck" name="newsletter">
                                        <label class="form-check-label" for="newsletterCheck">
                                            I would like to receive newsletters and travel updates from TravelPro
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="termsCheck" required>
                                        <label class="form-check-label" for="termsCheck">
                                            I agree to the <a href="#" data-bs-toggle="modal" data-bs-target="#privacyModal">Privacy Policy</a> and consent to processing my personal information *
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-send me-2"></i>Send Message
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Contact Information -->
            <div class="col-lg-4">
                <div class="contact-info-card">
                    <h4 class="mb-4">Get in Touch</h4>
                    
                    <div class="contact-item mb-4">
                        <div class="d-flex align-items-start">
                            <div class="contact-icon me-3">
                                <i class="bi bi-geo-alt"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Office Address</h6>
                                <p class="mb-0">123 Travel Street<br>Suite 456<br>New York, NY 10001<br>United States</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="contact-item mb-4">
                        <div class="d-flex align-items-start">
                            <div class="contact-icon me-3">
                                <i class="bi bi-telephone"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Phone Numbers</h6>
                                <p class="mb-0">
                                    Main: +1 234 567 8900<br>
                                    Toll-free: 1-800-TRAVEL<br>
                                    WhatsApp: +1 234 567 8900
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="contact-item mb-4">
                        <div class="d-flex align-items-start">
                            <div class="contact-icon me-3">
                                <i class="bi bi-envelope"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Email Addresses</h6>
                                <p class="mb-0">
                                    General: info@travelpro.com<br>
                                    Support: support@travelpro.com<br>
                                    Bookings: bookings@travelpro.com
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="contact-item mb-4">
                        <div class="d-flex align-items-start">
                            <div class="contact-icon me-3">
                                <i class="bi bi-clock"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Business Hours</h6>
                                <p class="mb-0">
                                    Monday - Friday: 9:00 AM - 6:00 PM<br>
                                    Saturday: 10:00 AM - 4:00 PM<br>
                                    Sunday: Closed<br>
                                    <small class="text-muted">24/7 Emergency support available</small>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Quick Actions -->
                <div class="card mt-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Quick Actions</h5>
                        <div class="d-grid gap-2">
                            <a href="{{ url('/consultation') }}" class="btn btn-outline-primary">
                                <i class="bi bi-calendar-check me-2"></i>Book Consultation
                            </a>
                            <a href="tel:+12345678900" class="btn btn-outline-success">
                                <i class="bi bi-telephone me-2"></i>Call Now
                            </a>
                            <a href="https://wa.me/1234567890" target="_blank" class="btn btn-outline-info">
                                <i class="bi bi-whatsapp me-2"></i>WhatsApp
                            </a>
                            <a href="mailto:info@travelpro.com" class="btn btn-outline-secondary">
                                <i class="bi bi-envelope me-2"></i>Email Us
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="section-title">Find Us</h2>
                <p class="section-subtitle">Visit our office or connect with us online</p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm">
                    <div class="card-body p-0">
                        <div id="map" style="height: 400px; width: 100%;">
                            <!-- Google Map will be embedded here -->
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3022.966309594933!2d-74.0060!3d40.7128!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNDDCsDQyJzQ2LjQiTiA3NMKwMDAnMzYuNiJX!5e0!3m2!1sen!2sus!4v1234567890" width="100%" height="400" style="border:0;" allowfullscreen loading="lazy"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="col-lg-4">
                <div class="text-center">
                    <div class="direction-icon">
                        <i class="bi bi-car-front"></i>
                    </div>
                    <h5>By Car</h5>
                    <p class="text-muted">Free parking available on-site. Access from Main Street.</p>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="text-center">
                    <div class="direction-icon">
                        <i class="bi bi-train-front"></i>
                    </div>
                    <h5>Public Transport</h5>
                    <p class="text-muted">5 minutes walk from Central Station. Bus lines 12, 34, 56.</p>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="text-center">
                    <div class="direction-icon">
                        <i class="bi bi-airplane"></i>
                    </div>
                    <h5>Airport</h5>
                    <p class="text-muted">30 minutes from JFK Airport. Shuttle service available.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="section-title">Our Team</h2>
                <p class="section-subtitle">Meet the experts ready to help you</p>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="team-member-card text-center">
                    <img src="https://picsum.photos/seed/team1/200/200.jpg" alt="Team Member" class="rounded-circle mb-3">
                    <h5>Sarah Johnson</h5>
                    <p class="text-muted small">Senior Travel Consultant</p>
                    <p class="small">Expert in visa services and international travel planning</p>
                    <div class="team-contact">
                        <a href="mailto:sarah@travelpro.com" class="btn btn-sm btn-outline-primary me-2">
                            <i class="bi bi-envelope"></i>
                        </a>
                        <a href="tel:+12345678901" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-telephone"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="team-member-card text-center">
                    <img src="https://picsum.photos/seed/team2/200/200.jpg" alt="Team Member" class="rounded-circle mb-3">
                    <h5>Michael Chen</h5>
                    <p class="text-muted small">Student Admission Specialist</p>
                    <p class="small">Helping students achieve their international education goals</p>
                    <div class="team-contact">
                        <a href="mailto:michael@travelpro.com" class="btn btn-sm btn-outline-primary me-2">
                            <i class="bi bi-envelope"></i>
                        </a>
                        <a href="tel:+12345678902" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-telephone"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="team-member-card text-center">
                    <img src="https://picsum.photos/seed/team3/200/200.jpg" alt="Team Member" class="rounded-circle mb-3">
                    <h5>Emily Rodriguez</h5>
                    <p class="text-muted small">Tour Package Manager</p>
                    <p class="small">Creating unforgettable travel experiences worldwide</p>
                    <div class="team-contact">
                        <a href="mailto:emily@travelpro.com" class="btn btn-sm btn-outline-primary me-2">
                            <i class="bi bi-envelope"></i>
                        </a>
                        <a href="tel:+12345678903" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-telephone"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="team-member-card text-center">
                    <img src="https://picsum.photos/seed/team4/200/200.jpg" alt="Team Member" class="rounded-circle mb-3">
                    <h5>David Williams</h5>
                    <p class="text-muted small">Customer Support Lead</p>
                    <p class="small">Ensuring smooth travel experiences for all clients</p>
                    <div class="team-contact">
                        <a href="mailto:david@travelpro.com" class="btn btn-sm btn-outline-primary me-2">
                            <i class="bi bi-envelope"></i>
                        </a>
                        <a href="tel:+12345678904" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-telephone"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Privacy Modal -->
<div class="modal fade" id="privacyModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Privacy Policy</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <h6>Information Collection</h6>
                <p>We collect information you provide directly to us, such as when you contact us for services, fill out a form, or communicate with us through our website.</p>
                
                <h6>How We Use Your Information</h6>
                <p>We use the information you provide to respond to your inquiries, provide our services, and communicate with you about travel-related matters.</p>
                
                <h6>Information Sharing</h6>
                <p>We do not sell, trade, or otherwise transfer your personal information to third parties without your consent, except as required by law.</p>
                
                <h6>Data Security</h6>
                <p>We implement appropriate security measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction.</p>
                
                <h6>Your Rights</h6>
                <p>You have the right to access, update, or delete your personal information. Contact us to exercise these rights.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.contact-info-card {
    background: white;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    height: 100%;
}

.contact-icon {
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--gradient-primary);
    border-radius: 50%;
    color: white;
    font-size: 1.2rem;
    flex-shrink: 0;
}

.contact-item {
    transition: all 0.3s ease;
}

.contact-item:hover {
    transform: translateX(5px);
}

.direction-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 20px;
    background: rgba(37, 99, 235, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: var(--primary-color);
}

.team-member-card {
    padding: 30px;
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    height: 100%;
}

.team-member-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
}

.team-member-card img {
    width: 120px;
    height: 120px;
    object-fit: cover;
    border: 3px solid var(--primary-color);
}

.team-contact {
    margin-top: 15px;
}

#map {
    border-radius: 10px;
    overflow: hidden;
}

@media (max-width: 768px) {
    .contact-info-card {
        margin-bottom: 30px;
    }
}
</style>
@endpush

@push('scripts')
<script>
// Contact form submission
document.getElementById('contactForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    submitFormAjax('contactForm', '/contact', function(data) {
        showToast('Message sent successfully! We will get back to you within 24 hours.', 'success');
        document.getElementById('contactForm').reset();
    }, function(error) {
        showToast(error.message || 'Failed to send message. Please try again.', 'error');
    });
});

// Auto-resize textarea
document.querySelector('textarea[name="message"]').addEventListener('input', function() {
    this.style.height = 'auto';
    this.style.height = this.scrollHeight + 'px';
});

// Subject-based form field updates
document.querySelector('select[name="subject"]').addEventListener('change', function() {
    const messageField = document.querySelector('textarea[name="message"]');
    const subject = this.value;
    
    // Add helpful placeholder text based on subject
    const placeholders = {
        'visa_inquiry': 'Please tell us which country you want to visit and what type of visa you need...',
        'student_admission': 'What course or field of study are you interested in? Which country?',
        'tour_booking': 'Which destination are you interested in? How many travelers? Preferred dates?',
        'consultation': 'What type of consultation do you need? Any specific questions?',
        'general_inquiry': 'Please provide details about your inquiry so we can assist you better...',
        'feedback': 'We value your feedback! Please share your thoughts with us...',
        'complaint': 'Please describe the issue you are experiencing so we can resolve it...',
        'partnership': 'Tell us about your organization and how you\'d like to partner with us...'
    };
    
    if (placeholders[subject]) {
        messageField.placeholder = placeholders[subject];
    }
});

// Phone number formatting
document.querySelector('input[name="phone"]').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length > 0) {
        if (value.length <= 3) {
            value = value;
        } else if (value.length <= 6) {
            value = value.slice(0, 3) + '-' + value.slice(3);
        } else {
            value = value.slice(0, 3) + '-' + value.slice(3, 6) + '-' + value.slice(6, 10);
        }
    }
    e.target.value = value;
});

// Form validation feedback
document.getElementById('contactForm').addEventListener('submit', function(e) {
    const form = e.target;
    const requiredFields = form.querySelectorAll('[required]');
    let isValid = true;
    
    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            field.classList.add('is-invalid');
            isValid = false;
        } else {
            field.classList.remove('is-invalid');
        }
    });
    
    if (!isValid) {
        e.preventDefault();
        showToast('Please fill in all required fields', 'error');
    }
});
</script>
@endpush