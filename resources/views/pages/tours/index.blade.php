@extends('layouts.app')

@section('title', 'Tours & Holiday Packages - TravelPro')

@section('meta-description', 'Exciting tour packages and holiday plans for unforgettable travel experiences. Browse our curated tours worldwide.')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1 class="display-4 fw-bold mb-4">Tours & Holiday Packages</h1>
                <p class="lead">Discover amazing destinations with our curated tour packages</p>
            </div>
        </div>
    </div>
</section>

<!-- Search and Filter Section -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <form id="tourSearchForm">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label">Destination</label>
                                    <input type="text" class="form-control" id="searchDestination" placeholder="Where to?">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Tour Type</label>
                                    <select class="form-select" id="tourType">
                                        <option value="">All Types</option>
                                        <option value="adventure">Adventure</option>
                                        <option value="cultural">Cultural</option>
                                        <option value="beach">Beach & Island</option>
                                        <option value="wildlife">Wildlife</option>
                                        <option value="romantic">Romantic</option>
                                        <option value="family">Family</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Duration</label>
                                    <select class="form-select" id="duration">
                                        <option value="">Any Duration</option>
                                        <option value="1-3">1-3 Days</option>
                                        <option value="4-7">4-7 Days</option>
                                        <option value="8-14">8-14 Days</option>
                                        <option value="15+">15+ Days</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Budget Range</label>
                                    <select class="form-select" id="budgetRange">
                                        <option value="">Any Budget</option>
                                        <option value="0-500">Under $500</option>
                                        <option value="500-1000">$500 - $1000</option>
                                        <option value="1000-2000">$1000 - $2000</option>
                                        <option value="2000+">$2000+</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-search me-2"></i>Search Tours
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary ms-2" onclick="resetFilters()">
                                        <i class="bi bi-arrow-clockwise me-2"></i>Reset
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

<!-- Featured Tours -->
<section class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="section-title">Featured Tours</h2>
                <p class="section-subtitle">Handpicked tours for unforgettable experiences</p>
            </div>
        </div>
        
        <div class="row g-4" id="toursContainer">
            <!-- Tour packages will be loaded here via AJAX -->
        </div>
        
        <div class="text-center mt-4">
            <div class="loading-spinner" id="loadingSpinner">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            <button class="btn btn-outline-primary" id="loadMoreBtn" onclick="loadMoreTours()">
                <i class="bi bi-arrow-down-circle me-2"></i>Load More Tours
            </button>
        </div>
    </div>
</section>

<!-- Tour Details Modal -->
<div class="modal fade" id="tourDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tourModalTitle">Tour Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="tourModalBody">
                <!-- Tour details will be loaded here -->
            </div>
        </div>
    </div>
</div>

<!-- Booking Form Modal -->
<div class="modal fade" id="bookingModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="bi bi-calendar-check me-2"></i>Book Your Tour
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="bookingForm">
                    @csrf
                    <input type="hidden" id="bookingTourId" name="tour_id">
                    
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
                            <label class="form-label">Number of Travelers *</label>
                            <input type="number" class="form-control" name="number_of_travelers" min="1" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Travel Date *</label>
                            <input type="date" class="form-control" name="travel_date" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Return Date *</label>
                            <input type="date" class="form-control" name="return_date" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Special Requests</label>
                            <textarea class="form-control" name="special_requests" rows="3"></textarea>
                        </div>
                        <div class="col-12">
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle me-2"></i>
                                <span id="bookingSummary">Tour details will appear here</span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="bookingTerms" required>
                                <label class="form-check-label" for="bookingTerms">
                                    I agree to the <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">Terms and Conditions</a> *
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="submitBooking()">
                    <i class="bi bi-check-circle me-2"></i>Confirm Booking
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Popular Categories -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="section-title">Browse by Category</h2>
                <p class="section-subtitle">Find tours that match your interests</p>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-2 col-md-4 col-6">
                <div class="category-card text-center" onclick="filterByCategory('adventure')">
                    <div class="category-icon">
                        <i class="bi bi-bicycle"></i>
                    </div>
                    <h6>Adventure</h6>
                    <small class="text-muted">25 Tours</small>
                </div>
            </div>
            
            <div class="col-lg-2 col-md-4 col-6">
                <div class="category-card text-center" onclick="filterByCategory('cultural')">
                    <div class="category-icon">
                        <i class="bi bi-building"></i>
                    </div>
                    <h6>Cultural</h6>
                    <small class="text-muted">18 Tours</small>
                </div>
            </div>
            
            <div class="col-lg-2 col-md-4 col-6">
                <div class="category-card text-center" onclick="filterByCategory('beach')">
                    <div class="category-icon">
                        <i class="bi bi-umbrella-beach"></i>
                    </div>
                    <h6>Beach</h6>
                    <small class="text-muted">22 Tours</small>
                </div>
            </div>
            
            <div class="col-lg-2 col-md-4 col-6">
                <div class="category-card text-center" onclick="filterByCategory('wildlife')">
                    <div class="category-icon">
                        <i class="bi bi-tree"></i>
                    </div>
                    <h6>Wildlife</h6>
                    <small class="text-muted">15 Tours</small>
                </div>
            </div>
            
            <div class="col-lg-2 col-md-4 col-6">
                <div class="category-card text-center" onclick="filterByCategory('romantic')">
                    <div class="category-icon">
                        <i class="bi bi-heart"></i>
                    </div>
                    <h6>Romantic</h6>
                    <small class="text-muted">12 Tours</small>
                </div>
            </div>
            
            <div class="col-lg-2 col-md-4 col-6">
                <div class="category-card text-center" onclick="filterByCategory('family')">
                    <div class="category-icon">
                        <i class="bi bi-people"></i>
                    </div>
                    <h6>Family</h6>
                    <small class="text-muted">20 Tours</small>
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
                <h5 class="modal-title">Booking Terms and Conditions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <h6>1. Booking Terms</h6>
                <p>By booking a tour with TravelPro, you agree to our terms of service and cancellation policy.</p>
                
                <h6>2. Payment Terms</h6>
                <p>50% advance payment required to confirm booking. Remaining balance due 30 days before travel.</p>
                
                <h6>3. Cancellation Policy</h6>
                <p>Cancellations made 30+ days before travel: Full refund minus 10% processing fee.</p>
                <p>Cancellations made 15-29 days before travel: 50% refund.</p>
                <p>Cancellations made less than 15 days before travel: No refund.</p>
                
                <h6>4. Travel Insurance</h6>
                <p>Travel insurance is mandatory for all international tours and recommended for domestic tours.</p>
                
                <h6>5. Responsibility</h6>
                <p>TravelPro is not responsible for any delays, cancellations, or changes due to weather, political situations, or other unforeseen circumstances.</p>
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
.tour-card {
    transition: all 0.3s ease;
    border: none;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    overflow: hidden;
}

.tour-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.15);
}

.tour-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    z-index: 1;
}

.tour-price {
    font-size: 1.5rem;
    font-weight: bold;
    color: var(--primary-color);
}

.tour-rating {
    color: #ffc107;
}

.category-card {
    padding: 20px;
    background: white;
    border-radius: 10px;
    box-shadow: 0 3px 15px rgba(0,0,0,0.1);
    cursor: pointer;
    transition: all 0.3s ease;
}

.category-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
}

.category-icon {
    width: 60px;
    height: 60px;
    margin: 0 auto 15px;
    background: var(--gradient-primary);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
}

.tour-features {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 10px;
}

.tour-feature {
    background: rgba(37, 99, 235, 0.1);
    color: var(--primary-color);
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 0.8rem;
}

.tour-image {
    height: 200px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.tour-card:hover .tour-image {
    transform: scale(1.05);
}
</style>
@endpush

@push('scripts')
<script>
let currentPage = 1;
let isLoading = false;
let currentFilters = {};

// Sample tour data (in real app, this would come from API)
const sampleTours = [
    {
        id: 1,
        title: "Dubai City Tour",
        destination: "Dubai, UAE",
        type: "cultural",
        duration: "5 days",
        price: 1299,
        rating: 4.8,
        image: "https://images.unsplash.com/photo-1512455039149-3cbb91b0b6f9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=870&q=80",
        description: "Experience the best of Dubai with city tours, desert safari, and shopping.",
        features: ["City Tour", "Desert Safari", "Shopping", "Burj Khalifa"]
    },
    {
        id: 2,
        title: "Singapore Adventure",
        destination: "Singapore",
        type: "adventure",
        duration: "4 days",
        price: 999,
        rating: 4.7,
        image: "https://images.unsplash.com/photo-1549188917-4e0a9c889244?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=870&q=80",
        description: "Explore Singapore's attractions including Universal Studios and Gardens by the Bay.",
        features: ["Universal Studios", "Gardens by the Bay", "Sentosa Island", "Night Safari"]
    },
    {
        id: 3,
        title: "Malaysia Beach Holiday",
        destination: "Kuala Lumpur, Malaysia",
        type: "beach",
        duration: "7 days",
        price: 799,
        rating: 4.6,
        image: "https://images.unsplash.com/photo-1537953774741-3d5a5fbd9f2a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=870&q=80",
        description: "Relax on beautiful beaches and explore Malaysia's vibrant culture.",
        features: ["Beach Resort", "City Tour", "Island Hopping", "Water Sports"]
    },
    {
        id: 4,
        title: "Thailand Cultural Experience",
        destination: "Bangkok, Thailand",
        type: "cultural",
        duration: "6 days",
        price: 899,
        rating: 4.9,
        image: "https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=870&q=80",
        description: "Discover Thailand's rich culture, temples, and delicious cuisine.",
        features: ["Temple Tours", "Floating Market", "Thai Cooking", "Elephant Sanctuary"]
    }
];

// Load initial tours
document.addEventListener('DOMContentLoaded', function() {
    loadTours();
});

function loadTours(filters = {}) {
    if (isLoading) return;
    
    isLoading = true;
    document.getElementById('loadingSpinner').classList.add('active');
    
    // Simulate API call
    setTimeout(() => {
        let filteredTours = sampleTours;
        
        // Apply filters
        if (filters.type) {
            filteredTours = filteredTours.filter(tour => tour.type === filters.type);
        }
        if (filters.destination) {
            filteredTours = filteredTours.filter(tour => 
                tour.destination.toLowerCase().includes(filters.destination.toLowerCase())
            );
        }
        
        displayTours(filteredTours);
        
        isLoading = false;
        document.getElementById('loadingSpinner').classList.remove('active');
    }, 1000);
}

function displayTours(tours) {
    const container = document.getElementById('toursContainer');
    container.innerHTML = '';
    
    tours.forEach(tour => {
        const tourCard = `
            <div class="col-lg-4 col-md-6">
                <div class="card tour-card">
                    <div class="position-relative">
                        <img src="${tour.image}" class="card-img-top tour-image" alt="${tour.title}">
                        <span class="badge bg-primary tour-badge">Featured</span>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title">${tour.title}</h5>
                            <div class="tour-rating">
                                <i class="bi bi-star-fill"></i> ${tour.rating}
                            </div>
                        </div>
                        <p class="text-muted small mb-2">
                            <i class="bi bi-geo-alt me-1"></i>${tour.destination}
                        </p>
                        <p class="card-text">${tour.description}</p>
                        <div class="tour-features">
                            ${tour.features.map(feature => `<span class="tour-feature">${feature}</span>`).join('')}
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div>
                                <span class="tour-price">$${tour.price}</span>
                                <small class="text-muted">/person</small>
                            </div>
                            <div>
                                <small class="text-muted me-2">
                                    <i class="bi bi-clock me-1"></i>${tour.duration}
                                </small>
                                <button class="btn btn-primary btn-sm" onclick="showTourDetails(${tour.id})">
                                    View Details
                                </button>
                            </div>
                        </div>
                        <div class="mt-3">
                            <button class="btn btn-outline-primary w-100" onclick="openBookingModal(${tour.id})">
                                <i class="bi bi-calendar-check me-2"></i>Book Now
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        container.innerHTML += tourCard;
    });
}

function showTourDetails(tourId) {
    const tour = sampleTours.find(t => t.id === tourId);
    if (!tour) return;
    
    const modalBody = document.getElementById('tourModalBody');
    modalBody.innerHTML = `
        <div class="row">
            <div class="col-md-6">
                <img src="${tour.image}" class="img-fluid rounded" alt="${tour.title}">
            </div>
            <div class="col-md-6">
                <h4>${tour.title}</h4>
                <p class="text-muted">
                    <i class="bi bi-geo-alt me-2"></i>${tour.destination}
                </p>
                <div class="mb-3">
                    <span class="badge bg-primary me-2">${tour.type}</span>
                    <span class="badge bg-info me-2">${tour.duration}</span>
                    <span class="tour-rating">
                        <i class="bi bi-star-fill"></i> ${tour.rating}
                    </span>
                </div>
                <p>${tour.description}</p>
                <h5 class="mt-4">Tour Highlights</h5>
                <ul>
                    ${tour.features.map(feature => `<li>${feature}</li>`).join('')}
                </ul>
                <div class="mt-4">
                    <h4 class="text-primary">$${tour.price} <small class="text-muted">/person</small></h4>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-12">
                <h5>What's Included</h5>
                <div class="row">
                    <div class="col-md-6">
                        <ul>
                            <li><i class="bi bi-check-circle text-success me-2"></i>Accommodation</li>
                            <li><i class="bi bi-check-circle text-success me-2"></i>Daily Breakfast</li>
                            <li><i class="bi bi-check-circle text-success me-2"></i>Airport Transfers</li>
                            <li><i class="bi bi-check-circle text-success me-2"></i>Sightseeing Tours</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul>
                            <li><i class="bi bi-check-circle text-success me-2"></i>Guide Services</li>
                            <li><i class="bi bi-check-circle text-success me-2"></i>Entrance Fees</li>
                            <li><i class="bi bi-check-circle text-success me-2"></i>Travel Insurance</li>
                            <li><i class="bi bi-check-circle text-success me-2"></i>24/7 Support</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    const modal = new bootstrap.Modal(document.getElementById('tourDetailsModal'));
    modal.show();
}

function openBookingModal(tourId) {
    const tour = sampleTours.find(t => t.id === tourId);
    if (!tour) return;
    
    document.getElementById('bookingTourId').value = tourId;
    document.getElementById('bookingSummary').innerHTML = `
        <strong>${tour.title}</strong> - ${tour.destination}<br>
        Duration: ${tour.duration} | Price: $${tour.price}/person
    `;
    
    const modal = new bootstrap.Modal(document.getElementById('bookingModal'));
    modal.show();
}

function submitBooking() {
    const form = document.getElementById('bookingForm');
    if (!validateForm('bookingForm')) {
        return;
    }
    
    submitFormAjax('bookingForm', '/bookings', function(data) {
        showToast('Booking submitted successfully! We will contact you soon.', 'success');
        bootstrap.Modal.getInstance(document.getElementById('bookingModal')).hide();
        form.reset();
    }, function(error) {
        showToast(error.message || 'Failed to submit booking', 'error');
    });
}

function filterByCategory(category) {
    currentFilters.type = category;
    loadTours(currentFilters);
    
    // Update form filter
    document.getElementById('tourType').value = category;
    
    // Scroll to tours section
    document.getElementById('toursContainer').scrollIntoView({ behavior: 'smooth' });
}

// Search form submission
document.getElementById('tourSearchForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    currentFilters = {
        destination: document.getElementById('searchDestination').value,
        type: document.getElementById('tourType').value,
        duration: document.getElementById('duration').value,
        budget: document.getElementById('budgetRange').value
    };
    
    loadTours(currentFilters);
});

function resetFilters() {
    document.getElementById('tourSearchForm').reset();
    currentFilters = {};
    loadTours();
}

function loadMoreTours() {
    // In real app, this would load more tours from the server
    showToast('All tours loaded', 'info');
    document.getElementById('loadMoreBtn').style.display = 'none';
}
</script>
@endpush