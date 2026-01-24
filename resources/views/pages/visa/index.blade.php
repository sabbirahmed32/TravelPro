@extends('layouts.app')

@section('title', 'Visa Services - TravelPro')

@section('meta-description', 'Professional visa assistance services for tourist, student, and work visas. Expert guidance for visa applications worldwide.')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1 class="display-4 fw-bold mb-4">Visa Services</h1>
                <p class="lead">Expert assistance for all your visa needs</p>
            </div>
        </div>
    </div>
</section>

<!-- Visa Services Overview -->
<section class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="section-title">Our Visa Services</h2>
                <p class="section-subtitle">Comprehensive visa solutions for international travel</p>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="card visa-service-card h-100">
                    <div class="card-body">
                        <div class="visa-icon mb-3">
                            <i class="bi bi-beach2 text-primary fs-1"></i>
                        </div>
                        <h4>Tourist Visa</h4>
                        <p class="mb-3">Quick and hassle-free tourist visa processing for leisure travelers worldwide.</p>
                        <ul class="list-unstyled mb-4">
                            <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Express processing available</li>
                            <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Document verification</li>
                            <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Application tracking</li>
                        </ul>
                        <button class="btn btn-primary" onclick="showVisaForm('tourist')">
                            <i class="bi bi-arrow-right me-2"></i>Apply Now
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="card visa-service-card h-100">
                    <div class="card-body">
                        <div class="visa-icon mb-3">
                            <i class="bi bi-mortarboard text-primary fs-1"></i>
                        </div>
                        <h4>Student Visa</h4>
                        <p class="mb-3">Complete guidance for student visa applications and admission processes.</p>
                        <ul class="list-unstyled mb-4">
                            <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>University admission assistance</li>
                            <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>SOP and LOR guidance</li>
                            <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Interview preparation</li>
                        </ul>
                        <button class="btn btn-primary" onclick="showVisaForm('student')">
                            <i class="bi bi-arrow-right me-2"></i>Apply Now
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="card visa-service-card h-100">
                    <div class="card-body">
                        <div class="visa-icon mb-3">
                            <i class="bi bi-briefcase text-primary fs-1"></i>
                        </div>
                        <h4>Work Visa</h4>
                        <p class="mb-3">Professional work visa assistance for employment opportunities abroad.</p>
                        <ul class="list-unstyled mb-4">
                            <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Job search assistance</li>
                            <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Work permit processing</li>
                            <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Relocation support</li>
                        </ul>
                        <button class="btn btn-primary" onclick="showVisaForm('work')">
                            <i class="bi bi-arrow-right me-2"></i>Apply Now
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Popular Countries -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="section-title">Popular Destinations</h2>
                <p class="section-subtitle">Visa services for top travel destinations</p>
            </div>
        </div>
        
        <div class="row g-4" id="countriesGrid">
            <div class="col-lg-3 col-md-6">
                <div class="card country-card h-100" data-country="usa">
                    <img src="https://images.unsplash.com/photo-1519904981063-b0cf448d479e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=870&q=80" 
                         class="card-img-top" alt="USA">
                    <div class="card-body">
                        <h5 class="card-title">United States</h5>
                        <p class="card-text small">Tourist, Student, Work visas</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-primary">Popular</span>
                            <button class="btn btn-sm btn-outline-primary" onclick="selectCountry('USA')">
                                Select
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="card country-card h-100" data-country="uk">
                    <img src="https://images.unsplash.com/photo-1512455039149-3cbb91b0b6f9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=870&q=80" 
                         class="card-img-top" alt="UK">
                    <div class="card-body">
                        <h5 class="card-title">United Kingdom</h5>
                        <p class="card-text small">Tourist, Student, Work visas</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-success">Available</span>
                            <button class="btn btn-sm btn-outline-primary" onclick="selectCountry('UK')">
                                Select
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="card country-card h-100" data-country="canada">
                    <img src="https://images.unsplash.com/photo-1518791841037-4b2285ad9158?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=870&q=80" 
                         class="card-img-top" alt="Canada">
                    <div class="card-body">
                        <h5 class="card-title">Canada</h5>
                        <p class="card-text small">Tourist, Student, Work visas</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-primary">Popular</span>
                            <button class="btn btn-sm btn-outline-primary" onclick="selectCountry('Canada')">
                                Select
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="card country-card h-100" data-country="australia">
                    <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=870&q=80" 
                         class="card-img-top" alt="Australia">
                    <div class="card-body">
                        <h5 class="card-title">Australia</h5>
                        <p class="card-text small">Tourist, Student, Work visas</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-success">Available</span>
                            <button class="btn btn-sm btn-outline-primary" onclick="selectCountry('Australia')">
                                Select
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-4">
            <button class="btn btn-outline-primary" onclick="loadMoreCountries()">
                <i class="bi bi-arrow-down-circle me-2"></i>Load More Countries
            </button>
        </div>
    </div>
</section>

<!-- Visa Application Form -->
<section class="section-padding" id="visaFormSection" style="display: none;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">
                            <i class="bi bi-file-earmark-text me-2"></i>
                            Visa Application Form
                        </h4>
                    </div>
                    <div class="card-body p-4">
                        <form id="visaApplicationForm">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Visa Type *</label>
                                    <select class="form-select" id="visaType" name="visa_type" required>
                                        <option value="">Select Visa Type</option>
                                        <option value="tourist">Tourist Visa</option>
                                        <option value="student">Student Visa</option>
                                        <option value="work">Work Visa</option>
                                        <option value="business">Business Visa</option>
                                        <option value="family">Family Visa</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label">Destination Country *</label>
                                    <select class="form-select" id="destinationCountry" name="destination_country" required>
                                        <option value="">Select Country</option>
                                        <option value="USA">United States</option>
                                        <option value="UK">United Kingdom</option>
                                        <option value="Canada">Canada</option>
                                        <option value="Australia">Australia</option>
                                        <option value="Germany">Germany</option>
                                        <option value="France">France</option>
                                        <option value="Japan">Japan</option>
                                        <option value="Singapore">Singapore</option>
                                        <option value="UAE">UAE</option>
                                        <option value="Malaysia">Malaysia</option>
                                    </select>
                                </div>
                                
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
                                    <label class="form-label">Date of Birth *</label>
                                    <input type="date" class="form-control" name="date_of_birth" required>
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label">Passport Number *</label>
                                    <input type="text" class="form-control" name="passport_number" required>
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label">Passport Expiry Date *</label>
                                    <input type="date" class="form-control" name="passport_expiry" required>
                                </div>
                                
                                <div class="col-12">
                                    <label class="form-label">Purpose of Travel *</label>
                                    <textarea class="form-control" name="purpose_of_travel" rows="3" required></textarea>
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label">Intended Travel Date *</label>
                                    <input type="date" class="form-control" name="intended_travel_date" required>
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label">Duration of Stay (days) *</label>
                                    <input type="number" class="form-control" name="duration_of_stay" min="1" required>
                                </div>
                                
                                <div class="col-12">
                                    <label class="form-label">Additional Information</label>
                                    <textarea class="form-control" name="additional_info" rows="3"></textarea>
                                </div>
                                
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="termsCheck" required>
                                        <label class="form-check-label" for="termsCheck">
                                            I agree to the <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">Terms and Conditions</a> *
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <div class="d-flex gap-3">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-send me-2"></i>Submit Application
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary" onclick="hideVisaForm()">
                                            <i class="bi bi-x-circle me-2"></i>Cancel
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Requirements Section -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="section-title">Visa Requirements</h2>
                <p class="section-subtitle">Common documents needed for visa applications</p>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-file-text me-2"></i>Required Documents</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Valid Passport (6+ months validity)</li>
                            <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Passport-size photographs</li>
                            <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Completed visa application form</li>
                            <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Proof of financial means</li>
                            <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Travel itinerary</li>
                            <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Travel insurance</li>
                            <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Accommodation proof</li>
                            <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Return flight tickets</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Processing Time</h5>
                    </div>
                    <div class="card-body">
                        <div class="processing-time-item mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Tourist Visa</span>
                                <span class="badge bg-info">5-15 working days</span>
                            </div>
                        </div>
                        <div class="processing-time-item mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Student Visa</span>
                                <span class="badge bg-warning">15-30 working days</span>
                            </div>
                        </div>
                        <div class="processing-time-item mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Work Visa</span>
                                <span class="badge bg-warning">20-45 working days</span>
                            </div>
                        </div>
                        <div class="processing-time-item mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Business Visa</span>
                                <span class="badge bg-info">7-20 working days</span>
                            </div>
                        </div>
                        <div class="alert alert-info mt-3">
                            <i class="bi bi-info-circle me-2"></i>
                            Processing times may vary based on country and season
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
                <h5 class="modal-title">Terms and Conditions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <h6>1. Service Terms</h6>
                <p>By submitting a visa application through TravelPro, you agree to our terms of service and privacy policy.</p>
                
                <h6>2. Application Processing</h6>
                <p>We process visa applications as per embassy requirements. Processing times may vary.</p>
                
                <h6>3. Payment Terms</h6>
                <p>Service fees are non-refundable once application processing begins.</p>
                
                <h6>4. Document Requirements</h6>
                <p>Applicants must provide authentic and complete documentation.</p>
                
                <h6>5. Privacy Policy</h6>
                <p>Your personal information is protected as per our privacy policy.</p>
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
.visa-service-card {
    transition: all 0.3s ease;
    border: none;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
}

.visa-service-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.15);
}

.visa-icon {
    width: 80px;
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(37, 99, 235, 0.1);
    border-radius: 50%;
    margin: 0 auto;
}

.country-card {
    transition: all 0.3s ease;
    cursor: pointer;
}

.country-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
}

.country-card.selected {
    border: 2px solid var(--primary-color);
    box-shadow: 0 0 20px rgba(37, 99, 235, 0.3);
}

.processing-time-item {
    padding: 10px;
    background: #f8f9fa;
    border-radius: 8px;
}
</style>
@endpush

@push('scripts')
<script>
let selectedCountry = '';
let selectedVisaType = '';

function showVisaForm(visaType) {
    selectedVisaType = visaType;
    document.getElementById('visaType').value = visaType;
    if (selectedCountry) {
        document.getElementById('destinationCountry').value = selectedCountry;
    }
    document.getElementById('visaFormSection').style.display = 'block';
    document.getElementById('visaFormSection').scrollIntoView({ behavior: 'smooth' });
}

function hideVisaForm() {
    document.getElementById('visaFormSection').style.display = 'none';
}

function selectCountry(country) {
    selectedCountry = country;
    
    // Update UI to show selected country
    document.querySelectorAll('.country-card').forEach(card => {
        card.classList.remove('selected');
    });
    
    const selectedCard = document.querySelector(`[data-country="${country.toLowerCase()}"]`);
    if (selectedCard) {
        selectedCard.classList.add('selected');
    }
    
    // Show form if visa type is selected
    if (selectedVisaType) {
        showVisaForm(selectedVisaType);
    } else {
        showToast('Please select a visa type first', 'info');
    }
}

function loadMoreCountries() {
    const countriesGrid = document.getElementById('countriesGrid');
    const additionalCountries = [
        { name: 'Germany', flag: '🇩🇪', status: 'Available', class: 'success' },
        { name: 'France', flag: '🇫🇷', status: 'Available', class: 'success' },
        { name: 'Japan', flag: '🇯🇵', status: 'Popular', class: 'primary' },
        { name: 'Singapore', flag: '🇸🇬', status: 'Available', class: 'success' }
    ];
    
    additionalCountries.forEach(country => {
        const countryCard = document.createElement('div');
        countryCard.className = 'col-lg-3 col-md-6';
        countryCard.innerHTML = `
            <div class="card country-card h-100">
                <div class="card-body text-center">
                    <div class="display-4 mb-3">${country.flag}</div>
                    <h5 class="card-title">${country.name}</h5>
                    <p class="card-text small">All visa types available</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-${country.class}">${country.status}</span>
                        <button class="btn btn-sm btn-outline-primary" onclick="selectCountry('${country.name}')">
                            Select
                        </button>
                    </div>
                </div>
            </div>
        `;
        countriesGrid.appendChild(countryCard);
    });
    
    // Hide load more button
    event.target.style.display = 'none';
}

// Form submission
document.getElementById('visaApplicationForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    submitFormAjax('visaApplicationForm', '/visa-applications', function(data) {
        showToast('Visa application submitted successfully! We will contact you soon.', 'success');
        document.getElementById('visaApplicationForm').reset();
        hideVisaForm();
    }, function(error) {
        showToast(error.message || 'Failed to submit application. Please try again.', 'error');
    });
});
</script>
@endpush