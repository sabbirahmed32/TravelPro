@extends('layouts.app')

@section('title', 'Consultation Booking - TravelPro')

@section('meta-description', 'Book expert travel consultation services. Get personalized advice for visas, student admissions, and tour planning.')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1 class="display-4 fw-bold mb-4">Travel Consultation</h1>
                <p class="lead">Expert guidance for your travel needs</p>
            </div>
        </div>
    </div>
</section>

<!-- Consultation Overview -->
<section class="section-padding">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="consultation-content">
                    <h2 class="section-title text-start">Why Choose Our Consultation?</h2>
                    <p class="mb-4">Get personalized advice from travel experts with years of experience. Our consultation services help you make informed decisions about your travel plans.</p>
                    
                    <div class="consultation-features">
                        <div class="feature-item mb-3">
                            <div class="d-flex align-items-start">
                                <div class="feature-icon me-3">
                                    <i class="bi bi-person-check text-primary fs-4"></i>
                                </div>
                                <div>
                                    <h5>Expert Guidance</h5>
                                    <p class="mb-0">Professional consultants with extensive travel industry knowledge</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="feature-item mb-3">
                            <div class="d-flex align-items-start">
                                <div class="feature-icon me-3">
                                    <i class="bi bi-clock text-primary fs-4"></i>
                                </div>
                                <div>
                                    <h5>Time Saving</h5>
                                    <p class="mb-0">Save hours of research with our curated recommendations</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="feature-item mb-3">
                            <div class="d-flex align-items-start">
                                <div class="feature-icon me-3">
                                    <i class="bi bi-currency-dollar text-primary fs-4"></i>
                                </div>
                                <div>
                                    <h5>Cost Effective</h5>
                                    <p class="mb-0">Find the best options within your budget</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="feature-item mb-3">
                            <div class="d-flex align-items-start">
                                <div class="feature-icon me-3">
                                    <i class="bi bi-shield-check text-primary fs-4"></i>
                                </div>
                                <div>
                                    <h5>Risk Free</h5>
                                    <p class="mb-0">Avoid common travel mistakes and pitfalls</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="consultation-types">
                    <h3 class="mb-4">Choose Your Consultation Type</h3>
                    
                    <div class="consultation-type-card" onclick="selectConsultationType('visa')">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="type-icon me-3">
                                    <i class="bi bi-passport text-primary fs-1"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="mb-1">Visa Consultation</h5>
                                    <p class="mb-0 text-muted small">Get expert advice on visa applications and requirements</p>
                                </div>
                                <div class="type-price">
                                    <h4 class="text-primary mb-0">$49</h4>
                                    <small class="text-muted">30 mins</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="consultation-type-card" onclick="selectConsultationType('student')">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="type-icon me-3">
                                    <i class="bi bi-mortarboard text-primary fs-1"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="mb-1">Student Admission</h5>
                                    <p class="mb-0 text-muted small">Guidance for university admissions and student visas</p>
                                </div>
                                <div class="type-price">
                                    <h4 class="text-primary mb-0">$99</h4>
                                    <small class="text-muted">60 mins</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="consultation-type-card" onclick="selectConsultationType('tour')">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="type-icon me-3">
                                    <i class="bi bi-airplane text-primary fs-1"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="mb-1">Tour Planning</h5>
                                    <p class="mb-0 text-muted small">Customized tour planning and itinerary design</p>
                                </div>
                                <div class="type-price">
                                    <h4 class="text-primary mb-0">$79</h4>
                                    <small class="text-muted">45 mins</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="consultation-type-card" onclick="selectConsultationType('comprehensive')">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="type-icon me-3">
                                    <i class="bi bi-star text-warning fs-1"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="mb-1">Comprehensive Package</h5>
                                    <p class="mb-0 text-muted small">Complete travel planning from A to Z</p>
                                </div>
                                <div class="type-price">
                                    <h4 class="text-primary mb-0">$149</h4>
                                    <small class="text-muted">90 mins</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Booking Form Section -->
<section class="section-padding bg-light" id="bookingFormSection" style="display: none;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">
                            <i class="bi bi-calendar-check me-2"></i>
                            Book Your Consultation
                        </h4>
                    </div>
                    <div class="card-body p-4">
                        <form id="consultationBookingForm">
                            @csrf
                            <input type="hidden" id="consultationType" name="consultation_type">
                            <input type="hidden" id="consultationPrice" name="price">
                            
                            <!-- Selected Consultation Info -->
                            <div class="alert alert-info mb-4" id="selectedConsultationInfo">
                                <!-- Will be populated dynamically -->
                            </div>
                            
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
                                    <label class="form-label">Country *</label>
                                    <select class="form-select" name="country" required>
                                        <option value="">Select Country</option>
                                        <option value="US">United States</option>
                                        <option value="UK">United Kingdom</option>
                                        <option value="CA">Canada</option>
                                        <option value="AU">Australia</option>
                                        <option value="IN">India</option>
                                        <option value="SG">Singapore</option>
                                        <option value="MY">Malaysia</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label">Preferred Date *</label>
                                    <input type="date" class="form-control" name="preferred_date" required>
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label">Preferred Time *</label>
                                    <select class="form-select" name="preferred_time" required>
                                        <option value="">Select Time</option>
                                        <option value="09:00">09:00 AM</option>
                                        <option value="10:00">10:00 AM</option>
                                        <option value="11:00">11:00 AM</option>
                                        <option value="14:00">02:00 PM</option>
                                        <option value="15:00">03:00 PM</option>
                                        <option value="16:00">04:00 PM</option>
                                        <option value="17:00">05:00 PM</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label">Time Zone *</label>
                                    <select class="form-select" name="time_zone" required>
                                        <option value="">Select Time Zone</option>
                                        <option value="EST">Eastern Time (EST)</option>
                                        <option value="CST">Central Time (CST)</option>
                                        <option value="MST">Mountain Time (MST)</option>
                                        <option value="PST">Pacific Time (PST)</option>
                                        <option value="GMT">Greenwich Mean Time (GMT)</option>
                                        <option value="CET">Central European Time (CET)</option>
                                        <option value="IST">India Standard Time (IST)</option>
                                        <option value="JST">Japan Standard Time (JST)</option>
                                        <option value="AEST">Australian Eastern Time (AEST)</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label">Consultation Mode *</label>
                                    <select class="form-select" name="consultation_mode" required>
                                        <option value="">Select Mode</option>
                                        <option value="video">Video Call</option>
                                        <option value="phone">Phone Call</option>
                                        <option value="in_person">In Person</option>
                                    </select>
                                </div>
                                
                                <div class="col-12">
                                    <label class="form-label">Travel Interests *</label>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="interests[]" value="visa" id="interest_visa">
                                                <label class="form-check-label" for="interest_visa">
                                                    Visa Services
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="interests[]" value="student" id="interest_student">
                                                <label class="form-check-label" for="interest_student">
                                                    Student Admission
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="interests[]" value="tours" id="interest_tours">
                                                <label class="form-check-label" for="interest_tours">
                                                    Tour Packages
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="interests[]" value="business" id="interest_business">
                                                <label class="form-check-label" for="interest_business">
                                                    Business Travel
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="interests[]" value="family" id="interest_family">
                                                <label class="form-check-label" for="interest_family">
                                                    Family Travel
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="interests[]" value="adventure" id="interest_adventure">
                                                <label class="form-check-label" for="interest_adventure">
                                                    Adventure Travel
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <label class="form-label">Specific Questions or Requirements</label>
                                    <textarea class="form-control" name="questions" rows="4" placeholder="Please describe your specific needs or questions..."></textarea>
                                </div>
                                
                                <div class="col-12">
                                    <label class="form-label">How did you hear about us?</label>
                                    <select class="form-select" name="referral_source">
                                        <option value="">Select Source</option>
                                        <option value="google">Google Search</option>
                                        <option value="facebook">Facebook</option>
                                        <option value="instagram">Instagram</option>
                                        <option value="friend">Friend/Colleague</option>
                                        <option value="advertisement">Advertisement</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                                
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="termsCheck" required>
                                        <label class="form-check-label" for="termsCheck">
                                            I agree to the <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">Terms and Conditions</a> and understand that consultation fees are non-refundable *
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Payment Section -->
                            <div class="mt-4 p-3 bg-light rounded">
                                <h5 class="mb-3">Payment Information</h5>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Card Number *</label>
                                        <input type="text" class="form-control" name="card_number" placeholder="1234 5678 9012 3456" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Card Holder Name *</label>
                                        <input type="text" class="form-control" name="card_holder" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Expiry Date *</label>
                                        <input type="text" class="form-control" name="card_expiry" placeholder="MM/YY" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">CVV *</label>
                                        <input type="text" class="form-control" name="card_cvv" placeholder="123" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Billing ZIP *</label>
                                        <input type="text" class="form-control" name="billing_zip" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-flex gap-3 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-credit-card me-2"></i>Pay & Book Consultation
                                </button>
                                <button type="button" class="btn btn-outline-secondary" onclick="hideBookingForm()">
                                    <i class="bi bi-x-circle me-2"></i>Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Process Section -->
<section class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="section-title">How It Works</h2>
                <p class="section-subtitle">Simple steps to get expert travel advice</p>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="text-center">
                    <div class="process-number">1</div>
                    <h5>Choose Consultation Type</h5>
                    <p>Select the consultation service that best fits your needs</p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="text-center">
                    <div class="process-number">2</div>
                    <h5>Book & Pay</h5>
                    <p>Schedule your appointment and complete payment securely</p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="text-center">
                    <div class="process-number">3</div>
                    <h5>Attend Consultation</h5>
                    <p>Meet with your travel expert via your preferred mode</p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="text-center">
                    <div class="process-number">4</div>
                    <h5>Get Action Plan</h5>
                    <p>Receive personalized recommendations and next steps</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="section-title">Client Testimonials</h2>
                <p class="section-subtitle">What our clients say about our consultation services</p>
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
                    <p class="mb-3">"The visa consultation was incredibly helpful. The consultant guided me through the entire process and helped me avoid common mistakes."</p>
                    <div class="d-flex align-items-center">
                        <img src="https://picsum.photos/seed/client1/50/50.jpg" alt="Client" class="rounded-circle me-3">
                        <div>
                            <h6 class="mb-0">Robert Johnson</h6>
                            <small class="text-muted">Visa Consultation</small>
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
                    <p class="mb-3">"Best investment for my study abroad journey! The consultant helped me choose the right university and guided me through the application process."</p>
                    <div class="d-flex align-items-center">
                        <img src="https://picsum.photos/seed/client2/50/50.jpg" alt="Client" class="rounded-circle me-3">
                        <div>
                            <h6 class="mb-0">Priya Sharma</h6>
                            <small class="text-muted">Student Admission</small>
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
                    <p class="mb-3">"The tour planning consultation saved us hours of research. We got a perfect itinerary tailored to our interests and budget."</p>
                    <div class="d-flex align-items-center">
                        <img src="https://picsum.photos/seed/client3/50/50.jpg" alt="Client" class="rounded-circle me-3">
                        <div>
                            <h6 class="mb-0">Maria Garcia</h6>
                            <small class="text-muted">Tour Planning</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Terms Modal -->
<div class="modal fade" id="termsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Consultation Terms and Conditions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <h6>1. Service Terms</h6>
                <p>By booking a consultation, you agree to receive travel advice and guidance from our expert consultants.</p>
                
                <h6>2. Payment Terms</h6>
                <p>Full payment is required at the time of booking. Consultation fees are non-refundable once booked.</p>
                
                <h6>3. Rescheduling Policy</h6>
                <p>Consultations can be rescheduled up to 24 hours before the scheduled time, subject to availability.</p>
                
                <h6>4. No-Show Policy</h6>
                <p>If you miss your scheduled consultation without prior notice, the fee will be forfeited.</p>
                
                <h6>5. Service Limitations</h6>
                <p>Consultation provides advice and guidance only. We do not guarantee visa approvals or university admissions.</p>
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
.consultation-type-card {
    border: 2px solid #e9ecef;
    border-radius: 10px;
    margin-bottom: 15px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.consultation-type-card:hover {
    border-color: var(--primary-color);
    box-shadow: 0 5px 20px rgba(37, 99, 235, 0.2);
    transform: translateY(-2px);
}

.consultation-type-card.selected {
    border-color: var(--primary-color);
    background: rgba(37, 99, 235, 0.05);
    box-shadow: 0 5px 20px rgba(37, 99, 235, 0.2);
}

.type-icon {
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(37, 99, 235, 0.1);
    border-radius: 50%;
}

.type-price {
    text-align: center;
}

.feature-icon {
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(37, 99, 235, 0.1);
    border-radius: 50%;
    flex-shrink: 0;
}

.process-number {
    width: 60px;
    height: 60px;
    background: var(--gradient-primary);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    font-weight: bold;
    margin: 0 auto 20px;
}

.testimonial-card {
    background: white;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    position: relative;
}

.testimonial-card::before {
    content: '"';
    position: absolute;
    top: -20px;
    left: 20px;
    font-size: 4rem;
    color: var(--primary-color);
    opacity: 0.3;
}

.rating {
    color: #ffc107;
}
</style>
@endpush

@push('scripts')
<script>
const consultationTypes = {
    visa: {
        name: 'Visa Consultation',
        price: 49,
        duration: '30 minutes',
        description: 'Expert advice on visa applications and requirements'
    },
    student: {
        name: 'Student Admission',
        price: 99,
        duration: '60 minutes',
        description: 'Guidance for university admissions and student visas'
    },
    tour: {
        name: 'Tour Planning',
        price: 79,
        duration: '45 minutes',
        description: 'Customized tour planning and itinerary design'
    },
    comprehensive: {
        name: 'Comprehensive Package',
        price: 149,
        duration: '90 minutes',
        description: 'Complete travel planning from A to Z'
    }
};

let selectedType = '';

function selectConsultationType(type) {
    selectedType = type;
    const consultation = consultationTypes[type];
    
    // Update UI to show selected type
    document.querySelectorAll('.consultation-type-card').forEach(card => {
        card.classList.remove('selected');
    });
    event.currentTarget.classList.add('selected');
    
    // Update form
    document.getElementById('consultationType').value = type;
    document.getElementById('consultationPrice').value = consultation.price;
    
    // Update selected info
    document.getElementById('selectedConsultationInfo').innerHTML = `
        <strong>${consultation.name}</strong><br>
        Duration: ${consultation.duration} | Price: $${consultation.price}<br>
        <small>${consultation.description}</small>
    `;
    
    // Show booking form
    document.getElementById('bookingFormSection').style.display = 'block';
    document.getElementById('bookingFormSection').scrollIntoView({ behavior: 'smooth' });
}

function hideBookingForm() {
    document.getElementById('bookingFormSection').style.display = 'none';
    document.querySelectorAll('.consultation-type-card').forEach(card => {
        card.classList.remove('selected');
    });
    selectedType = '';
}

// Form submission
document.getElementById('consultationBookingForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Validate at least one interest is selected
    const interests = document.querySelectorAll('input[name="interests[]"]:checked');
    if (interests.length === 0) {
        showToast('Please select at least one travel interest', 'error');
        return;
    }
    
    submitFormAjax('consultationBookingForm', '/consultations', function(data) {
        showToast('Consultation booked successfully! You will receive a confirmation email shortly.', 'success');
        document.getElementById('consultationBookingForm').reset();
        hideBookingForm();
    }, function(error) {
        showToast(error.message || 'Failed to book consultation', 'error');
    });
});

// Set minimum date to today
document.addEventListener('DOMContentLoaded', function() {
    const dateInput = document.querySelector('input[name="preferred_date"]');
    if (dateInput) {
        const today = new Date().toISOString().split('T')[0];
        dateInput.min = today;
    }
});
</script>
@endpush