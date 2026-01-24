@extends('layouts.app')

@section('title', 'Student Admission - TravelPro')

@section('meta-description', 'Complete student admission services for universities worldwide. Expert guidance for applications, visas, and pre-departure preparation.')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1 class="display-4 fw-bold mb-4">Student Admission Services</h1>
                <p class="lead">Your pathway to international education</p>
            </div>
        </div>
    </div>
</section>

<!-- Admission Process Overview -->
<section class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="section-title">Our Admission Process</h2>
                <p class="section-subtitle">Step-by-step guidance to your dream university</p>
            </div>
        </div>
        
        <div class="row process-steps">
            <div class="col-lg-12">
                <div class="process-timeline">
                    <div class="process-step">
                        <div class="step-number">1</div>
                        <div class="step-content">
                            <h5>Initial Consultation</h5>
                            <p>Discuss your academic goals, preferences, and budget with our expert counselors.</p>
                        </div>
                    </div>
                    
                    <div class="process-step">
                        <div class="step-number">2</div>
                        <div class="step-content">
                            <h5>University Selection</h5>
                            <p>Shortlist suitable universities based on your profile and career aspirations.</p>
                        </div>
                    </div>
                    
                    <div class="process-step">
                        <div class="step-number">3</div>
                        <div class="step-content">
                            <h5>Application Preparation</h5>
                            <p>Complete application forms, essays, and gather required documents.</p>
                        </div>
                    </div>
                    
                    <div class="process-step">
                        <div class="step-number">4</div>
                        <div class="step-content">
                            <h5>Submission & Follow-up</h5>
                            <p>Submit applications and track their progress with universities.</p>
                        </div>
                    </div>
                    
                    <div class="process-step">
                        <div class="step-number">5</div>
                        <div class="step-content">
                            <h5>Offer Acceptance</h5>
                            <p>Review offers, make decisions, and complete enrollment procedures.</p>
                        </div>
                    </div>
                    
                    <div class="process-step">
                        <div class="step-number">6</div>
                        <div class="step-content">
                            <h5>Visa Processing</h5>
                            <p>Apply for student visa with our expert guidance and support.</p>
                        </div>
                    </div>
                    
                    <div class="process-step">
                        <div class="step-number">7</div>
                        <div class="step-content">
                            <h5>Pre-departure Preparation</h5>
                            <p>Assistance with accommodation, flights, and orientation for your journey.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Popular Study Destinations -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="section-title">Popular Study Destinations</h2>
                <p class="section-subtitle">Top countries for international education</p>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="card study-destination-card h-100">
                    <img src="https://images.unsplash.com/photo-1519904981063-b0cf448d479e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=870&q=80" 
                         class="card-img-top" alt="USA">
                    <div class="card-body">
                        <h5 class="card-title">United States</h5>
                        <p class="card-text small">World's leading education destination</p>
                        <ul class="list-unstyled small mb-3">
                            <li><i class="bi bi-check-circle text-success me-1"></i>4000+ universities</li>
                            <li><i class="bi bi-check-circle text-success me-1"></i>STEM programs</li>
                            <li><i class="bi bi-check-circle text-success me-1"></i>Research opportunities</li>
                        </ul>
                        <button class="btn btn-primary btn-sm w-100" onclick="selectStudyDestination('USA')">
                            Learn More
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="card study-destination-card h-100">
                    <img src="https://images.unsplash.com/photo-1512455039149-3cbb91b0b6f9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=870&q=80" 
                         class="card-img-top" alt="UK">
                    <div class="card-body">
                        <h5 class="card-title">United Kingdom</h5>
                        <p class="card-text small">Quality education and rich culture</p>
                        <ul class="list-unstyled small mb-3">
                            <li><i class="bi bi-check-circle text-success me-1"></i>3-year programs</li>
                            <li><i class="bi bi-check-circle text-success me-1"></i>Post-study work visa</li>
                            <li><i class="bi bi-check-circle text-success me-1"></i>Historic universities</li>
                        </ul>
                        <button class="btn btn-primary btn-sm w-100" onclick="selectStudyDestination('UK')">
                            Learn More
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="card study-destination-card h-100">
                    <img src="https://images.unsplash.com/photo-1518791841037-4b2285ad9158?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=870&q=80" 
                         class="card-img-top" alt="Canada">
                    <div class="card-body">
                        <h5 class="card-title">Canada</h5>
                        <p class="card-text small">Affordable education with PR options</p>
                        <ul class="list-unstyled small mb-3">
                            <li><i class="bi bi-check-circle text-success me-1"></i>Co-op programs</li>
                            <li><i class="bi bi-check-circle text-success me-1"></i>Immigration pathways</li>
                            <li><i class="bi bi-check-circle text-success me-1"></i>Safe environment</li>
                        </ul>
                        <button class="btn btn-primary btn-sm w-100" onclick="selectStudyDestination('Canada')">
                            Learn More
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="card study-destination-card h-100">
                    <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=870&q=80" 
                         class="card-img-top" alt="Australia">
                    <div class="card-body">
                        <h5 class="card-title">Australia</h5>
                        <p class="card-text small">Excellent education system</p>
                        <ul class="list-unstyled small mb-3">
                            <li><i class="bi bi-check-circle text-success me-1"></i>Top-ranked universities</li>
                            <li><i class="bi bi-check-circle text-success me-1"></i>Work opportunities</li>
                            <li><i class="bi bi-check-circle text-success me-1"></i>Quality of life</li>
                        </ul>
                        <button class="btn btn-primary btn-sm w-100" onclick="selectStudyDestination('Australia')">
                            Learn More
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Student Application Form -->
<section class="section-padding" id="applicationFormSection" style="display: none;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">
                            <i class="bi bi-mortarboard me-2"></i>
                            Student Application Form
                        </h4>
                    </div>
                    <div class="card-body p-4">
                        <!-- Progress Steps -->
                        <div class="application-progress mb-4">
                            <div class="progress-steps d-flex justify-content-between">
                                <div class="step active" data-step="1">
                                    <div class="step-circle">1</div>
                                    <span>Personal Info</span>
                                </div>
                                <div class="step" data-step="2">
                                    <div class="step-circle">2</div>
                                    <span>Academic</span>
                                </div>
                                <div class="step" data-step="3">
                                    <div class="step-circle">3</div>
                                    <span>Preferences</span>
                                </div>
                                <div class="step" data-step="4">
                                    <div class="step-circle">4</div>
                                    <span>Documents</span>
                                </div>
                            </div>
                        </div>
                        
                        <form id="studentApplicationForm">
                            @csrf
                            <!-- Step 1: Personal Information -->
                            <div class="form-step" data-step="1">
                                <h5 class="mb-4">Personal Information</h5>
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
                                        <label class="form-label">Date of Birth *</label>
                                        <input type="date" class="form-control" name="date_of_birth" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Gender *</label>
                                        <select class="form-select" name="gender" required>
                                            <option value="">Select Gender</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Nationality *</label>
                                        <input type="text" class="form-control" name="nationality" required>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Current Address *</label>
                                        <textarea class="form-control" name="address" rows="2" required></textarea>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end mt-4">
                                    <button type="button" class="btn btn-primary" onclick="nextStep(2)">
                                        Next <i class="bi bi-arrow-right ms-2"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Step 2: Academic Information -->
                            <div class="form-step" data-step="2" style="display: none;">
                                <h5 class="mb-4">Academic Information</h5>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Highest Education *</label>
                                        <select class="form-select" name="highest_education" required>
                                            <option value="">Select Education Level</option>
                                            <option value="high_school">High School</option>
                                            <option value="bachelors">Bachelor's Degree</option>
                                            <option value="masters">Master's Degree</option>
                                            <option value="phd">PhD</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Field of Study *</label>
                                        <input type="text" class="form-control" name="field_of_study" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">GPA/Percentage *</label>
                                        <input type="text" class="form-control" name="gpa" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Graduation Year *</label>
                                        <input type="number" class="form-control" name="graduation_year" min="2000" max="2024" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">English Test</label>
                                        <select class="form-select" name="english_test">
                                            <option value="">Select Test</option>
                                            <option value="ielts">IELTS</option>
                                            <option value="toefl">TOEFL</option>
                                            <option value="pte">PTE</option>
                                            <option value="none">Not Taken</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Test Score</label>
                                        <input type="text" class="form-control" name="test_score" placeholder="e.g., 7.0 bands">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Work Experience (if any)</label>
                                        <textarea class="form-control" name="work_experience" rows="2"></textarea>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between mt-4">
                                    <button type="button" class="btn btn-outline-secondary" onclick="previousStep(1)">
                                        <i class="bi bi-arrow-left me-2"></i>Previous
                                    </button>
                                    <button type="button" class="btn btn-primary" onclick="nextStep(3)">
                                        Next <i class="bi bi-arrow-right ms-2"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Step 3: Study Preferences -->
                            <div class="form-step" data-step="3" style="display: none;">
                                <h5 class="mb-4">Study Preferences</h5>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Preferred Country *</label>
                                        <select class="form-select" name="preferred_country" required>
                                            <option value="">Select Country</option>
                                            <option value="USA">United States</option>
                                            <option value="UK">United Kingdom</option>
                                            <option value="Canada">Canada</option>
                                            <option value="Australia">Australia</option>
                                            <option value="Germany">Germany</option>
                                            <option value="New Zealand">New Zealand</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Preferred Course Level *</label>
                                        <select class="form-select" name="course_level" required>
                                            <option value="">Select Level</option>
                                            <option value="diploma">Diploma</option>
                                            <option value="bachelors">Bachelor's</option>
                                            <option value="masters">Master's</option>
                                            <option value="phd">PhD</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Preferred Course *</label>
                                        <input type="text" class="form-control" name="preferred_course" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Intake Semester *</label>
                                        <select class="form-select" name="intake_semester" required>
                                            <option value="">Select Intake</option>
                                            <option value="fall_2024">Fall 2024</option>
                                            <option value="spring_2025">Spring 2025</option>
                                            <option value="fall_2025">Fall 2025</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Budget Range (USD/year) *</label>
                                        <select class="form-select" name="budget_range" required>
                                            <option value="">Select Budget</option>
                                            <option value="10000-15000">$10,000 - $15,000</option>
                                            <option value="15000-20000">$15,000 - $20,000</option>
                                            <option value="20000-25000">$20,000 - $25,000</option>
                                            <option value="25000-30000">$25,000 - $30,000</option>
                                            <option value="30000+">$30,000+</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Funding Source *</label>
                                        <select class="form-select" name="funding_source" required>
                                            <option value="">Select Source</option>
                                            <option value="self_funded">Self Funded</option>
                                            <option value="parents">Parents</option>
                                            <option value="scholarship">Scholarship</option>
                                            <option value="education_loan">Education Loan</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Additional Requirements</label>
                                        <textarea class="form-control" name="additional_requirements" rows="2"></textarea>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between mt-4">
                                    <button type="button" class="btn btn-outline-secondary" onclick="previousStep(2)">
                                        <i class="bi bi-arrow-left me-2"></i>Previous
                                    </button>
                                    <button type="button" class="btn btn-primary" onclick="nextStep(4)">
                                        Next <i class="bi bi-arrow-right ms-2"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Step 4: Document Upload -->
                            <div class="form-step" data-step="4" style="display: none;">
                                <h5 class="mb-4">Document Upload</h5>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Passport Copy *</label>
                                        <input type="file" class="form-control" name="passport_copy" accept=".pdf,.jpg,.png" required>
                                        <small class="text-muted">PDF, JPG, PNG (Max 5MB)</small>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Academic Transcripts *</label>
                                        <input type="file" class="form-control" name="transcripts" accept=".pdf,.jpg,.png" required>
                                        <small class="text-muted">PDF, JPG, PNG (Max 5MB)</small>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Degree Certificate</label>
                                        <input type="file" class="form-control" name="degree_certificate" accept=".pdf,.jpg,.png">
                                        <small class="text-muted">PDF, JPG, PNG (Max 5MB)</small>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">English Test Score</label>
                                        <input type="file" class="form-control" name="english_test_score" accept=".pdf,.jpg,.png">
                                        <small class="text-muted">PDF, JPG, PNG (Max 5MB)</small>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Resume/CV</label>
                                        <input type="file" class="form-control" name="resume" accept=".pdf,.doc,.docx">
                                        <small class="text-muted">PDF, DOC, DOCX (Max 5MB)</small>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Statement of Purpose</label>
                                        <input type="file" class="form-control" name="sop" accept=".pdf,.doc,.docx">
                                        <small class="text-muted">PDF, DOC, DOCX (Max 5MB)</small>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Additional Comments</label>
                                        <textarea class="form-control" name="comments" rows="3"></textarea>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="termsCheck" required>
                                            <label class="form-check-label" for="termsCheck">
                                                I agree to the <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">Terms and Conditions</a> and consent to processing my personal information *
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between mt-4">
                                    <button type="button" class="btn btn-outline-secondary" onclick="previousStep(3)">
                                        <i class="bi bi-arrow-left me-2"></i>Previous
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-send me-2"></i>Submit Application
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="section-title">Our Services</h2>
                <p class="section-subtitle">Comprehensive support for your study abroad journey</p>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="bi bi-search"></i>
                    </div>
                    <h5>University Search</h5>
                    <p>Find the best universities matching your profile and preferences</p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="bi bi-file-earmark-text"></i>
                    </div>
                    <h5>Application Support</h5>
                    <p>Complete assistance with application forms and documentation</p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="bi bi-passport"></i>
                    </div>
                    <h5>Visa Processing</h5>
                    <p>Expert guidance for student visa applications and interviews</p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="bi bi-house-door"></i>
                    </div>
                    <h5>Accommodation</h5>
                    <p>Help with finding suitable accommodation near your university</p>
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
                <h6>Student Admission Services</h6>
                <p>By submitting this application, you agree to our terms of service for student admission assistance.</p>
                
                <h6>Application Processing</h6>
                <p>We will process your application and help you find suitable universities based on your profile.</p>
                
                <h6>Service Fees</h6>
                <p>Service fees are applicable and will be communicated before proceeding with university applications.</p>
                
                <h6>Document Privacy</h6>
                <p>Your personal documents and information are kept confidential as per our privacy policy.</p>
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
.process-timeline {
    position: relative;
    padding: 20px 0;
}

.process-timeline::before {
    content: '';
    position: absolute;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 2px;
    height: 100%;
    background: var(--primary-color);
}

.process-step {
    display: flex;
    align-items: center;
    margin-bottom: 40px;
    position: relative;
}

.process-step:nth-child(odd) {
    flex-direction: row;
}

.process-step:nth-child(even) {
    flex-direction: row-reverse;
}

.step-number {
    width: 60px;
    height: 60px;
    background: var(--primary-color);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 1.2rem;
    z-index: 1;
    margin: 0 20px;
}

.step-content {
    flex: 1;
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
}

.study-destination-card {
    transition: all 0.3s ease;
    border: none;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
}

.study-destination-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.15);
}

.application-progress {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 30px;
}

.progress-steps {
    position: relative;
}

.progress-steps::before {
    content: '';
    position: absolute;
    top: 20px;
    left: 0;
    right: 0;
    height: 2px;
    background: #dee2e6;
    z-index: 0;
}

.step {
    position: relative;
    z-index: 1;
    text-align: center;
    flex: 1;
}

.step-circle {
    width: 40px;
    height: 40px;
    background: #dee2e6;
    color: #6c757d;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 10px;
    font-weight: bold;
    transition: all 0.3s ease;
}

.step.active .step-circle {
    background: var(--primary-color);
    color: white;
}

.step span {
    font-size: 0.9rem;
    color: #6c757d;
}

.step.active span {
    color: var(--primary-color);
    font-weight: 500;
}

@media (max-width: 768px) {
    .process-timeline::before {
        left: 30px;
    }
    
    .process-step {
        flex-direction: row !important;
    }
    
    .step-number {
        margin: 0 20px 0 0;
    }
}
</style>
@endpush

@push('scripts')
<script>
let currentStep = 1;

function nextStep(step) {
    // Validate current step
    const currentStepElement = document.querySelector(`.form-step[data-step="${currentStep}"]`);
    const requiredFields = currentStepElement.querySelectorAll('[required]');
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
        showToast('Please fill in all required fields', 'error');
        return;
    }
    
    // Hide current step
    currentStepElement.style.display = 'none';
    
    // Update progress
    document.querySelector(`.step[data-step="${currentStep}"]`).classList.remove('active');
    document.querySelector(`.step[data-step="${step}"]`).classList.add('active');
    
    // Show next step
    document.querySelector(`.form-step[data-step="${step}"]`).style.display = 'block';
    currentStep = step;
    
    // Scroll to top of form
    document.getElementById('applicationFormSection').scrollIntoView({ behavior: 'smooth' });
}

function previousStep(step) {
    // Hide current step
    document.querySelector(`.form-step[data-step="${currentStep}"]`).style.display = 'none';
    
    // Update progress
    document.querySelector(`.step[data-step="${currentStep}"]`).classList.remove('active');
    document.querySelector(`.step[data-step="${step}"]`).classList.add('active');
    
    // Show previous step
    document.querySelector(`.form-step[data-step="${step}"]`).style.display = 'block';
    currentStep = step;
    
    // Scroll to top of form
    document.getElementById('applicationFormSection').scrollIntoView({ behavior: 'smooth' });
}

function selectStudyDestination(country) {
    document.getElementById('applicationFormSection').style.display = 'block';
    document.getElementById('applicationFormSection').scrollIntoView({ behavior: 'smooth' });
}

// Form submission
document.getElementById('studentApplicationForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Create FormData for file upload
    const formData = new FormData(this);
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    
    // Show loading state
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Submitting...';
    
    fetch('/student-applications', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('Application submitted successfully! We will contact you within 24 hours.', 'success');
            this.reset();
            document.getElementById('applicationFormSection').style.display = 'none';
            currentStep = 1;
            // Reset progress
            document.querySelectorAll('.step').forEach(step => step.classList.remove('active'));
            document.querySelector('.step[data-step="1"]').classList.add('active');
            document.querySelectorAll('.form-step').forEach(step => step.style.display = 'none');
            document.querySelector('.form-step[data-step="1"]').style.display = 'block';
        } else {
            showToast(data.message || 'Failed to submit application', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('An error occurred. Please try again.', 'error');
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    });
});
</script>
@endpush