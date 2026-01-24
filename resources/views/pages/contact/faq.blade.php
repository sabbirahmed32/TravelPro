@extends('layouts.app')

@section('title', 'FAQ - TravelPro')

@section('meta-description', 'Frequently asked questions about our travel services, visa applications, student admissions, and tour packages.')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1 class="display-4 fw-bold mb-4">Frequently Asked Questions</h1>
                <p class="lead">Find answers to common questions about our services</p>
            </div>
        </div>
    </div>
</section>

<!-- Search Section -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="mb-3">Search for Answers</h5>
                        <form id="faqSearchForm">
                            <div class="input-group">
                                <input type="text" class="form-control" id="faqSearchInput" placeholder="Type your question here...">
                                <button class="btn btn-primary" type="submit">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Categories -->
<section class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="faq-categories">
                    <button class="category-btn active" onclick="filterFAQ('all')">All Questions</button>
                    <button class="category-btn" onclick="filterFAQ('visa')">Visa Services</button>
                    <button class="category-btn" onclick="filterFAQ('student')">Student Admission</button>
                    <button class="category-btn" onclick="filterFAQ('tours')">Tours & Packages</button>
                    <button class="category-btn" onclick="filterFAQ('consultation')">Consultation</button>
                    <button class="category-btn" onclick="filterFAQ('payment')">Payment & Booking</button>
                    <button class="category-btn" onclick="filterFAQ('general')">General</button>
                </div>
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="col-lg-12">
                <div class="faq-accordion" id="faqAccordion">
                    <!-- Visa Services FAQ -->
                    <div class="faq-item" data-category="visa">
                        <div class="card">
                            <div class="card-header" id="visaHeading1">
                                <h5 class="mb-0">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#visaCollapse1">
                                        What documents are required for a tourist visa application?
                                    </button>
                                </h5>
                            </div>
                            <div id="visaCollapse1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                <div class="card-body">
                                    <p>For a tourist visa application, you typically need:</p>
                                    <ul>
                                        <li>Valid passport (6+ months validity)</li>
                                        <li>Completed visa application form</li>
                                        <li>Passport-size photographs</li>
                                        <li>Proof of financial means</li>
                                        <li>Travel itinerary</li>
                                        <li>Travel insurance</li>
                                        <li>Accommodation proof</li>
                                        <li>Return flight tickets</li>
                                    </ul>
                                    <p class="mt-3">Requirements may vary by country, so please check specific requirements for your destination.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="faq-item" data-category="visa">
                        <div class="card">
                            <div class="card-header" id="visaHeading2">
                                <h5 class="mb-0">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#visaCollapse2">
                                        How long does it take to process a visa application?
                                    </button>
                                </h5>
                            </div>
                            <div id="visaCollapse2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="card-body">
                                    <p>Visa processing times vary by country and visa type:</p>
                                    <ul>
                                        <li><strong>Tourist Visa:</strong> 5-15 working days</li>
                                        <li><strong>Student Visa:</strong> 15-30 working days</li>
                                        <li><strong>Work Visa:</strong> 20-45 working days</li>
                                        <li><strong>Business Visa:</strong> 7-20 working days</li>
                                    </ul>
                                    <p class="mt-3">Express processing is available for some countries at additional cost. Processing times may be longer during peak seasons.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="faq-item" data-category="visa">
                        <div class="card">
                            <div class="card-header" id="visaHeading3">
                                <h5 class="mb-0">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#visaCollapse3">
                                        Can you guarantee visa approval?
                                    </button>
                                </h5>
                            </div>
                            <div id="visaCollapse3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="card-body">
                                    <p>No, we cannot guarantee visa approval as the final decision rests with the immigration authorities of the destination country. However, we:</p>
                                    <ul>
                                        <li>Ensure your application is complete and accurate</li>
                                        <li>Provide expert guidance on requirements</li>
                                        <li>Help you avoid common mistakes</li>
                                        <li>Prepare you for interviews if required</li>
                                        <li>Maximize your chances of success</li>
                                    </ul>
                                    <p class="mt-3">Our success rate is over 95% for properly documented applications.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Student Admission FAQ -->
                    <div class="faq-item" data-category="student">
                        <div class="card">
                            <div class="card-header" id="studentHeading1">
                                <h5 class="mb-0">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#studentCollapse1">
                                        What are the requirements for studying abroad?
                                    </button>
                                </h5>
                            </div>
                            <div id="studentCollapse1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="card-body">
                                    <p>Basic requirements for studying abroad include:</p>
                                    <ul>
                                        <li>Academic qualifications (transcripts, certificates)</li>
                                        <li>English language proficiency (IELTS/TOEFL)</li>
                                        <li>Statement of Purpose (SOP)</li>
                                        <li>Letters of Recommendation (LOR)</li>
                                        <li>Valid passport</li>
                                        <li>Financial proof/sponsorship</li>
                                        <li>Student visa</li>
                                    </ul>
                                    <p class="mt-3">Requirements vary by country and university. We help you understand specific requirements for your chosen destination.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="faq-item" data-category="student">
                        <div class="card">
                            <div class="card-header" id="studentHeading2">
                                <h5 class="mb-0">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#studentCollapse2">
                                        How do you help with university applications?
                                    </button>
                                </h5>
                            </div>
                            <div id="studentCollapse2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="card-body">
                                    <p>We provide comprehensive support for university applications:</p>
                                    <ul>
                                        <li>University selection based on your profile</li>
                                        <li>Application form assistance</li>
                                        <li>SOP writing and review</li>
                                        <li>LOR guidance</li>
                                        <li>Document preparation</li>
                                        <li>Application submission</li>
                                        <li>Follow-up with universities</li>
                                        <li>Offer acceptance guidance</li>
                                    </ul>
                                    <p class="mt-3">Our experienced counselors guide you through every step of the process.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="faq-item" data-category="student">
                        <div class="card">
                            <div class="card-header" id="studentHeading3">
                                <h5 class="mb-0">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#studentCollapse3">
                                        What is the cost of studying abroad?
                                    </button>
                                </h5>
                            </div>
                            <div id="studentCollapse3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="card-body">
                                    <p>Study abroad costs vary significantly by country and institution:</p>
                                    <ul>
                                        <li><strong>USA:</strong> $20,000 - $60,000 per year</li>
                                        <li><strong>UK:</strong> £15,000 - £35,000 per year</li>
                                        <li><strong>Canada:</strong> $16,000 - $35,000 per year</li>
                                        <li><strong>Australia:</strong> $20,000 - $45,000 per year</li>
                                        <li><strong>Germany:</strong> €0 - €20,000 per year (many public universities are free)</li>
                                    </ul>
                                    <p class="mt-3">Additional costs include accommodation, living expenses, health insurance, and flights. We help you find affordable options and scholarships.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tours & Packages FAQ -->
                    <div class="faq-item" data-category="tours">
                        <div class="card">
                            <div class="card-header" id="tourHeading1">
                                <h5 class="mb-0">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#tourCollapse1">
                                        What is included in your tour packages?
                                    </button>
                                </h5>
                            </div>
                            <div id="tourCollapse1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="card-body">
                                    <p>Our tour packages typically include:</p>
                                    <ul>
                                        <li>Accommodation (hotels/resorts)</li>
                                        <li>Daily breakfast</li>
                                        <li>Airport transfers</li>
                                        <li>Sightseeing tours</li>
                                        <li>Guide services</li>
                                        <li>Entrance fees to attractions</li>
                                        <li>Travel insurance</li>
                                        <li>24/7 support</li>
                                    </ul>
                                    <p class="mt-3">Specific inclusions vary by package. Please check individual tour details for complete information.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="faq-item" data-category="tours">
                        <div class="card">
                            <div class="card-header" id="tourHeading2">
                                <h5 class="mb-0">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#tourCollapse2">
                                        Can you customize tour packages?
                                    </button>
                                </h5>
                            </div>
                            <div id="tourCollapse2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="card-body">
                                    <p>Yes! We offer customized tour packages tailored to your preferences:</p>
                                    <ul>
                                        <li>Flexible duration</li>
                                        <li>Customized itinerary</li>
                                        <li>Preferred accommodation type</li>
                                        <li>Special interests (adventure, culture, relaxation)</li>
                                        <li>Dietary requirements</li>
                                        <li>Group size preferences</li>
                                        <li>Budget adjustments</li>
                                    </ul>
                                    <p class="mt-3">Contact our travel experts to create your perfect customized tour.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="faq-item" data-category="tours">
                        <div class="card">
                            <div class="card-header" id="tourHeading3">
                                <h5 class="mb-0">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#tourCollapse3">
                                        What is your cancellation policy?
                                    </button>
                                </h5>
                            </div>
                            <div id="tourCollapse3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="card-body">
                                    <p>Our cancellation policy is as follows:</p>
                                    <ul>
                                        <li><strong>30+ days before travel:</strong> Full refund minus 10% processing fee</li>
                                        <li><strong>15-29 days before travel:</strong> 50% refund</li>
                                        <li><strong>8-14 days before travel:</strong> 25% refund</li>
                                        <li><strong>Less than 7 days before travel:</strong> No refund</li>
                                    </ul>
                                    <p class="mt-3">Some special packages may have different cancellation terms. Please check specific package terms before booking.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Consultation FAQ -->
                    <div class="faq-item" data-category="consultation">
                        <div class="card">
                            <div class="card-header" id="consultationHeading1">
                                <h5 class="mb-0">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#consultationCollapse1">
                                        How does the consultation service work?
                                    </button>
                                </h5>
                            </div>
                            <div id="consultationCollapse1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="card-body">
                                    <p>Our consultation process is simple:</p>
                                    <ol>
                                        <li>Choose your consultation type (visa, student, tour, comprehensive)</li>
                                        <li>Book and pay for your session</li>
                                        <li>Receive confirmation with meeting details</li>
                                        <li>Attend consultation via video call, phone, or in-person</li>
                                        <li>Get personalized advice and action plan</li>
                                        <li>Follow-up support via email</li>
                                    </ol>
                                    <p class="mt-3">Sessions range from 30-90 minutes depending on the consultation type.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="faq-item" data-category="consultation">
                        <div class="card">
                            <div class="card-header" id="consultationHeading2">
                                <h5 class="mb-0">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#consultationCollapse2">
                                        Are consultation fees refundable?
                                    </button>
                                </h5>
                            </div>
                            <div id="consultationCollapse2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="card-body">
                                    <p>Consultation fees are non-refundable once booked. However:</p>
                                    <ul>
                                        <li>You can reschedule up to 24 hours before your appointment</li>
                                        <li>If we need to cancel, we'll offer a full refund or reschedule</li>
                                        <li>Technical difficulties will be resolved with rescheduling</li>
                                    </ul>
                                    <p class="mt-3">Please ensure you're available at the scheduled time to avoid losing your consultation fee.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Payment & Booking FAQ -->
                    <div class="faq-item" data-category="payment">
                        <div class="card">
                            <div class="card-header" id="paymentHeading1">
                                <h5 class="mb-0">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#paymentCollapse1">
                                        What payment methods do you accept?
                                    </button>
                                </h5>
                            </div>
                            <div id="paymentCollapse1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="card-body">
                                    <p>We accept multiple payment methods:</p>
                                    <ul>
                                        <li>Credit/Debit cards (Visa, MasterCard, American Express)</li>
                                        <li>Bank transfers</li>
                                        <li>PayPal</li>
                                        <li>Digital wallets (Apple Pay, Google Pay)</li>
                                        <li>Cash (for in-person payments)</li>
                                    </ul>
                                    <p class="mt-3">All payments are processed securely through encrypted payment gateways.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="faq-item" data-category="payment">
                        <div class="card">
                            <div class="card-header" id="paymentHeading2">
                                <h5 class="mb-0">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#paymentCollapse2">
                                        Is my payment information secure?
                                    </button>
                                </h5>
                            </div>
                            <div id="paymentCollapse2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="card-body">
                                    <p>Yes, your payment information is completely secure:</p>
                                    <ul>
                                        <li>We use SSL encryption for all transactions</li>
                                        <li>Payment details are never stored on our servers</li>
                                        <li>We comply with PCI DSS standards</li>
                                        <li>Trusted payment gateways process all payments</li>
                                        <li>Regular security audits and updates</li>
                                    </ul>
                                    <p class="mt-3">Your security is our top priority.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- General FAQ -->
                    <div class="faq-item" data-category="general">
                        <div class="card">
                            <div class="card-header" id="generalHeading1">
                                <h5 class="mb-0">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#generalCollapse1">
                                        How long have you been in business?
                                    </button>
                                </h5>
                            </div>
                            <div id="generalCollapse1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="card-body">
                                    <p>TravelPro has been in business for over 10 years, since 2014. We've successfully helped more than 5,000 clients achieve their travel goals and maintain a 98% customer satisfaction rate.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="faq-item" data-category="general">
                        <div class="card">
                            <div class="card-header" id="generalHeading2">
                                <h5 class="mb-0">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#generalCollapse2">
                                        Do you provide support after booking?
                                    </button>
                                </h5>
                            </div>
                            <div id="generalCollapse2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="card-body">
                                    <p>Yes, we provide comprehensive support after booking:</p>
                                    <ul>
                                        <li>24/7 emergency support during travel</li>
                                        <li>Pre-departure guidance and information</li>
                                        <li>Regular updates and communication</li>
                                        <li>Assistance with any issues that arise</li>
                                        <li>Post-travel feedback and follow-up</li>
                                    </ul>
                                    <p class="mt-3">Our relationship doesn't end after booking - we're here to support you throughout your journey.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="faq-item" data-category="general">
                        <div class="card">
                            <div class="card-header" id="generalHeading3">
                                <h5 class="mb-0">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#generalCollapse3">
                                        How can I contact customer support?
                                    </button>
                                </h5>
                            </div>
                            <div id="generalCollapse3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="card-body">
                                    <p>You can reach our customer support team through:</p>
                                    <ul>
                                        <li><strong>Phone:</strong> +1 234 567 8900 (Mon-Fri, 9AM-6PM)</li>
                                        <li><strong>Email:</strong> support@travelpro.com</li>
                                        <li><strong>Live Chat:</strong> Available on our website</li>
                                        <li><strong>WhatsApp:</strong> +1 234 567 8900</li>
                                        <li><strong>Contact Form:</strong> Available on our website</li>
                                    </ul>
                                    <p class="mt-3">For urgent matters during travel, we have a 24/7 emergency hotline.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- No Results Message -->
        <div class="row" id="noResults" style="display: none;">
            <div class="col-lg-12 text-center">
                <div class="alert alert-info">
                    <h5>No matching questions found</h5>
                    <p>Try different search terms or browse all categories above.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Still Have Questions Section -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-title">Still Have Questions?</h2>
                <p class="section-subtitle">Can't find what you're looking for? Our team is here to help!</p>
                
                <div class="row g-4 mt-4">
                    <div class="col-lg-4">
                        <div class="contact-option-card">
                            <div class="contact-icon">
                                <i class="bi bi-telephone"></i>
                            </div>
                            <h5>Call Us</h5>
                            <p>+1 234 567 8900</p>
                            <small class="text-muted">Mon-Fri, 9AM-6PM</small>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="contact-option-card">
                            <div class="contact-icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                            <h5>Email Us</h5>
                            <p>support@travelpro.com</p>
                            <small class="text-muted">We respond within 24 hours</small>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="contact-option-card">
                            <div class="contact-icon">
                                <i class="bi bi-chat-dots"></i>
                            </div>
                            <h5>Live Chat</h5>
                            <p>Chat with our team</p>
                            <small class="text-muted">Available on our website</small>
                        </div>
                    </div>
                </div>
                
                <div class="mt-5">
                    <a href="{{ url('/contact') }}" class="btn btn-primary btn-lg">
                        <i class="bi bi-envelope me-2"></i>Contact Support
                    </a>
                    <a href="{{ url('/consultation') }}" class="btn btn-outline-primary btn-lg ms-3">
                        <i class="bi bi-calendar-check me-2"></i>Book Consultation
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
.faq-categories {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    justify-content: center;
    margin-bottom: 30px;
}

.category-btn {
    padding: 10px 20px;
    border: 2px solid #dee2e6;
    background: white;
    border-radius: 25px;
    cursor: pointer;
    transition: all 0.3s ease;
    font-weight: 500;
}

.category-btn:hover,
.category-btn.active {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
}

.faq-accordion .accordion-button {
    font-weight: 500;
    color: var(--dark-color);
}

.faq-accordion .accordion-button:not(.collapsed) {
    color: var(--primary-color);
    background: rgba(37, 99, 235, 0.05);
}

.faq-item {
    margin-bottom: 10px;
}

.contact-option-card {
    padding: 30px;
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    text-align: center;
    transition: all 0.3s ease;
    height: 100%;
}

.contact-option-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
}

.contact-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 20px;
    background: var(--gradient-primary);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: white;
}

@media (max-width: 768px) {
    .faq-categories {
        justify-content: flex-start;
        overflow-x: auto;
        flex-wrap: nowrap;
        padding-bottom: 10px;
    }
    
    .category-btn {
        white-space: nowrap;
        flex-shrink: 0;
    }
}
</style>
@endpush

@push('scripts')
<script>
function filterFAQ(category) {
    // Update active button
    document.querySelectorAll('.category-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    event.target.classList.add('active');
    
    // Filter FAQ items
    const faqItems = document.querySelectorAll('.faq-item');
    let hasResults = false;
    
    faqItems.forEach(item => {
        if (category === 'all' || item.dataset.category === category) {
            item.style.display = 'block';
            hasResults = true;
        } else {
            item.style.display = 'none';
        }
    });
    
    // Show/hide no results message
    document.getElementById('noResults').style.display = hasResults ? 'none' : 'block';
}

// FAQ Search
document.getElementById('faqSearchForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const searchTerm = document.getElementById('faqSearchInput').value.toLowerCase();
    
    if (searchTerm) {
        const faqItems = document.querySelectorAll('.faq-item');
        let hasResults = false;
        
        faqItems.forEach(item => {
            const question = item.querySelector('.accordion-button').textContent.toLowerCase();
            const answer = item.querySelector('.card-body').textContent.toLowerCase();
            
            if (question.includes(searchTerm) || answer.includes(searchTerm)) {
                item.style.display = 'block';
                hasResults = true;
                
                // Expand the matching item
                const collapse = item.querySelector('.accordion-collapse');
                if (collapse && !collapse.classList.contains('show')) {
                    new bootstrap.Collapse(collapse, { show: true });
                }
            } else {
                item.style.display = 'none';
            }
        });
        
        document.getElementById('noResults').style.display = hasResults ? 'none' : 'block';
        
        // Reset category buttons
        document.querySelectorAll('.category-btn').forEach(btn => {
            btn.classList.remove('active');
        });
        document.querySelector('.category-btn').classList.add('active');
    } else {
        // Show all items if search is empty
        document.querySelectorAll('.faq-item').forEach(item => {
            item.style.display = 'block';
        });
        document.getElementById('noResults').style.display = 'none';
    }
});

// Real-time search
document.getElementById('faqSearchInput').addEventListener('input', function() {
    if (this.value === '') {
        // Reset to show all items
        document.querySelectorAll('.faq-item').forEach(item => {
            item.style.display = 'block';
        });
        document.getElementById('noResults').style.display = 'none';
    }
});

// URL hash handling for direct FAQ links
document.addEventListener('DOMContentLoaded', function() {
    const hash = window.location.hash;
    if (hash) {
        const targetElement = document.querySelector(hash);
        if (targetElement) {
            // Expand the target FAQ
            const collapse = targetElement.querySelector('.accordion-collapse');
            if (collapse && !collapse.classList.contains('show')) {
                new bootstrap.Collapse(collapse, { show: true });
            }
            
            // Scroll to the FAQ
            setTimeout(() => {
                targetElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }, 500);
        }
    }
});
</script>
@endpush