/**
 * Travel Business Frontend JavaScript
 * Handles all interactive functionality for the website
 */

// Global variables
let currentPage = 1;
let isLoading = false;

// Utility functions
function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `toast-notification ${type}`;
    toast.innerHTML = `
        <div class="toast-content">
            <i class="bi ${type === 'success' ? 'bi-check-circle' : 'bi-exclamation-circle'}"></i>
            <span>${message}</span>
        </div>
        <button class="toast-close" onclick="this.parentElement.remove()">
            <i class="bi bi-x"></i>
        </button>
    `;
    
    document.body.appendChild(toast);
    
    // Animate in
    setTimeout(() => toast.classList.add('show'), 100);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => toast.remove(), 300);
    }, 5000);
}

function showLoadingSpinner(element) {
    element.innerHTML = `
        <div class="text-center p-4">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    `;
}

function hideLoadingSpinner(element, content) {
    element.innerHTML = content;
}

function formatCurrency(amount) {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
    }).format(amount);
}

function formatDate(dateString) {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString(undefined, options);
}

// Form validation
function validateForm(formId, rules) {
    const form = document.getElementById(formId);
    if (!form) return false;
    
    let isValid = true;
    const errors = {};
    
    rules.forEach(rule => {
        const field = form.querySelector(`[name="${rule.name}"]`);
        if (!field) return;
        
        const value = field.value.trim();
        
        // Required validation
        if (rule.required && !value) {
            errors[rule.name] = rule.message || `${rule.name} is required`;
            isValid = false;
            field.classList.add('is-invalid');
        } else {
            field.classList.remove('is-invalid');
        }
        
        // Email validation
        if (rule.type === 'email' && value) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(value)) {
                errors[rule.name] = 'Please enter a valid email address';
                isValid = false;
                field.classList.add('is-invalid');
            }
        }
        
        // Phone validation
        if (rule.type === 'phone' && value) {
            const phoneRegex = /^[\d\s\-\+\(\)]+$/;
            if (!phoneRegex.test(value)) {
                errors[rule.name] = 'Please enter a valid phone number';
                isValid = false;
                field.classList.add('is-invalid');
            }
        }
        
        // File validation
        if (rule.type === 'file' && field.files.length > 0) {
            field.files.forEach(file => {
                const maxSize = rule.maxSize || 5 * 1024 * 1024; // 5MB default
                const allowedTypes = rule.allowedTypes || ['application/pdf', 'image/jpeg', 'image/png'];
                
                if (file.size > maxSize) {
                    errors[rule.name] = `File size must be less than ${maxSize / (1024 * 1024)}MB`;
                    isValid = false;
                    field.classList.add('is-invalid');
                }
                
                if (!allowedTypes.includes(file.type)) {
                    errors[rule.name] = 'Only PDF, JPG, and PNG files are allowed';
                    isValid = false;
                    field.classList.add('is-invalid');
                }
            });
        }
    });
    
    // Display errors
    const errorContainer = form.querySelector('.error-messages');
    if (errorContainer) {
        if (Object.keys(errors).length > 0) {
            errorContainer.innerHTML = Object.values(errors).map(error => 
                `<div class="alert alert-danger">${error}</div>`
            ).join('');
            errorContainer.style.display = 'block';
        } else {
            errorContainer.innerHTML = '';
            errorContainer.style.display = 'none';
        }
    }
    
    return isValid;
}

// AJAX helper
async function makeRequest(url, options = {}) {
    const defaultOptions = {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
        }
    };
    
    const finalOptions = { ...defaultOptions, ...options };
    
    try {
        const response = await fetch(url, finalOptions);
        const data = await response.json();
        
        if (!response.ok) {
            throw new Error(data.message || 'Something went wrong');
        }
        
        return data;
    } catch (error) {
        showToast(error.message, 'error');
        throw error;
    }
}

// Contact form handler
document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            if (!validateForm('contactForm', [
                { name: 'full_name', required: true },
                { name: 'email', type: 'email', required: true },
                { name: 'phone', type: 'phone', required: true },
                { name: 'message', required: true }
            ])) {
                return;
            }
            
            const submitBtn = contactForm.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Sending...';
            
            try {
                const formData = new FormData(contactForm);
                const data = Object.fromEntries(formData.entries());
                
                await makeRequest('/api/contact', {
                    method: 'POST',
                    body: JSON.stringify(data)
                });
                
                showToast('Message sent successfully! We\'ll get back to you soon.');
                contactForm.reset();
                
            } catch (error) {
                console.error('Contact form error:', error);
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }
        });
    }
    
    // Visa application form
    const visaForm = document.getElementById('visaApplicationForm');
    if (visaForm) {
        visaForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            if (!validateForm('visaApplicationForm', [
                { name: 'first_name', required: true },
                { name: 'last_name', required: true },
                { name: 'email', type: 'email', required: true },
                { name: 'phone', type: 'phone', required: true },
                { name: 'passport_number', required: true },
                { name: 'destination_country', required: true },
                { name: 'visa_type', required: true },
                { name: 'documents', type: 'file', allowedTypes: ['application/pdf', 'image/jpeg', 'image/png'], maxSize: 5 * 1024 * 1024 }
            ])) {
                return;
            }
            
            const submitBtn = visaForm.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Submitting...';
            
            try {
                const formData = new FormData(visaForm);
                
                await makeRequest('/api/visa-applications', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                    }
                });
                
                showToast('Visa application submitted successfully!');
                visaForm.reset();
                
                // Close modal if in modal
                const modal = bootstrap.Modal.getInstance(visaForm.closest('.modal'));
                if (modal) modal.hide();
                
            } catch (error) {
                console.error('Visa application error:', error);
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }
        });
    }
    
    // Tour search and filtering
    const tourSearchForm = document.getElementById('tourSearchForm');
    if (tourSearchForm) {
        tourSearchForm.addEventListener('submit', function(e) {
            e.preventDefault();
            searchTours();
        });
        
        // Auto-search on input change
        ['searchDestination', 'tourType', 'duration', 'budget'].forEach(id => {
            const element = document.getElementById(id);
            if (element) {
                element.addEventListener('change', searchTours);
                if (id === 'searchDestination') {
                    element.addEventListener('input', debounce(searchTours, 500));
                }
            }
        });
    }
    
    // File upload preview
    const fileInputs = document.querySelectorAll('input[type="file"]');
    fileInputs.forEach(input => {
        input.addEventListener('change', function() {
            const files = Array.from(this.files);
            const preview = this.closest('.form-group').querySelector('.file-preview');
            
            if (preview && files.length > 0) {
                preview.innerHTML = files.map(file => `
                    <div class="file-item">
                        <i class="bi ${file.type.includes('pdf') ? 'bi-file-pdf' : 'bi-file-image'}"></i>
                        <span>${file.name}</span>
                        <small class="text-muted">(${(file.size / 1024).toFixed(1)} KB)</small>
                    </div>
                `).join('');
            }
        });
    });
});

// Tour search function
async function searchTours() {
    if (isLoading) return;
    isLoading = true;
    
    const container = document.getElementById('toursContainer');
    if (container) {
        showLoadingSpinner(container);
    }
    
    try {
        const destination = document.getElementById('searchDestination')?.value || '';
        const tourType = document.getElementById('tourType')?.value || '';
        const duration = document.getElementById('duration')?.value || '';
        const budget = document.getElementById('budget')?.value || '';
        
        const params = new URLSearchParams({
            destination,
            tour_type: tourType,
            duration,
            budget,
            page: currentPage
        });
        
        const data = await makeRequest(`/api/tours/search?${params}`);
        
        if (container) {
            container.innerHTML = data.tours.map(tour => `
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card tour-card h-100">
                        <div class="position-relative">
                            <img src="${tour.image}" class="card-img-top" alt="${tour.title}">
                            <div class="tour-badge ${tour.badge.toLowerCase()}">${tour.badge}</div>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">${tour.title}</h5>
                            <p class="card-text flex-grow-1">${tour.description}</p>
                            <div class="tour-meta mb-3">
                                <span class="duration"><i class="bi bi-clock"></i> ${tour.duration}</span>
                                <span class="price text-primary fw-bold">${formatCurrency(tour.price)}</span>
                            </div>
                            <button class="btn btn-primary w-100" onclick="showTourDetails(${tour.id})">
                                View Details
                            </button>
                        </div>
                    </div>
                </div>
            `).join('');
        }
        
        // Update pagination
        updatePagination(data.pagination);
        
    } catch (error) {
        if (container) {
            container.innerHTML = '<div class="col-12 text-center"><p class="text-danger">Failed to load tours. Please try again.</p></div>';
        }
    } finally {
        isLoading = false;
    }
}

// Show tour details modal
async function showTourDetails(tourId) {
    try {
        const tour = await makeRequest(`/api/tours/${tourId}`);
        
        // Create modal if doesn't exist
        let modal = document.getElementById('tourDetailsModal');
        if (!modal) {
            document.body.insertAdjacentHTML('beforeend', `
                <div class="modal fade" id="tourDetailsModal" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Tour Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Content will be inserted here -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" id="bookTourBtn">Book Now</button>
                            </div>
                        </div>
                    </div>
                </div>
            `);
            modal = document.getElementById('tourDetailsModal');
        }
        
        // Update modal content
        modal.querySelector('.modal-body').innerHTML = `
            <div class="row">
                <div class="col-md-6">
                    <img src="${tour.image}" class="img-fluid rounded" alt="${tour.title}">
                </div>
                <div class="col-md-6">
                    <h4>${tour.title}</h4>
                    <p class="text-muted">${tour.description}</p>
                    <div class="tour-details">
                        <p><strong>Duration:</strong> ${tour.duration}</p>
                        <p><strong>Price:</strong> <span class="text-primary">${formatCurrency(tour.price)}</span></p>
                        <p><strong>Includes:</strong></p>
                        <ul>
                            ${tour.includes.map(item => `<li>${item}</li>`).join('')}
                        </ul>
                    </div>
                </div>
            </div>
        `;
        
        // Setup book button
        const bookBtn = modal.querySelector('#bookTourBtn');
        bookBtn.onclick = function() {
            bootstrap.Modal.getInstance(modal).hide();
            showBookingForm(tour.id);
        };
        
        // Show modal
        const bsModal = new bootstrap.Modal(modal);
        bsModal.show();
        
    } catch (error) {
        showToast('Failed to load tour details', 'error');
    }
}

// Show booking form
function showBookingForm(tourId) {
    // Implementation for booking form
    showToast('Booking form opening...', 'info');
}

// Update pagination
function updatePagination(pagination) {
    const container = document.getElementById('paginationContainer');
    if (!container) return;
    
    if (pagination.current_page === pagination.last_page) {
        container.innerHTML = '';
        return;
    }
    
    container.innerHTML = `
        <div class="d-flex justify-content-center mt-4">
            <button class="btn btn-outline-primary" onclick="loadMoreTours()" ${isLoading ? 'disabled' : ''}>
                ${isLoading ? '<span class="spinner-border spinner-border-sm me-2"></span>Loading...' : 'Load More'}
            </button>
        </div>
    `;
}

// Load more tours
function loadMoreTours() {
    currentPage++;
    searchTours();
}

// Debounce function
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// WhatsApp button functionality
function openWhatsApp(phoneNumber, message) {
    const url = `https://wa.me/${phoneNumber.replace(/[^0-9]/g, '')}?text=${encodeURIComponent(message)}`;
    window.open(url, '_blank');
}

// Smooth scroll to section
function scrollToSection(sectionId) {
    const section = document.getElementById(sectionId);
    if (section) {
        section.scrollIntoView({ behavior: 'smooth' });
    }
}

// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});

// Initialize back to top button
window.addEventListener('scroll', function() {
    const backToTopBtn = document.getElementById('backToTop');
    if (backToTopBtn) {
        if (window.pageYOffset > 300) {
            backToTopBtn.style.display = 'block';
        } else {
            backToTopBtn.style.display = 'none';
        }
    }
});

// Back to top function
function scrollToTop() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// Tour filtering functions
function filterByDestination() {
    searchTours();
}

function filterByType() {
    searchTours();
}

function filterByBudget() {
    searchTours();
}

function filterByDuration() {
    searchTours();
}

// Student admission multi-step form
let currentStep = 1;
const totalSteps = 7;

function nextStep() {
    if (currentStep < totalSteps) {
        if (validateCurrentStep()) {
            document.getElementById(`step${currentStep}`).style.display = 'none';
            currentStep++;
            document.getElementById(`step${currentStep}`).style.display = 'block';
            updateProgressBar();
            scrollToTop();
        }
    }
}

function prevStep() {
    if (currentStep > 1) {
        document.getElementById(`step${currentStep}`).style.display = 'none';
        currentStep--;
        document.getElementById(`step${currentStep}`).style.display = 'block';
        updateProgressBar();
        scrollToTop();
    }
}

function updateProgressBar() {
    const progressBar = document.getElementById('progressBar');
    if (progressBar) {
        const progress = (currentStep / totalSteps) * 100;
        progressBar.style.width = `${progress}%`;
        progressBar.setAttribute('aria-valuenow', progress);
    }
}

function validateCurrentStep() {
    // Implementation for step validation
    return true; // Simplified for example
}

// Export functions for global access
window.showToast = showToast;
window.showTourDetails = showTourDetails;
window.openWhatsApp = openWhatsApp;
window.scrollToSection = scrollToSection;
window.scrollToTop = scrollToTop;
window.nextStep = nextStep;
window.prevStep = prevStep;
window.filterByDestination = filterByDestination;
window.filterByType = filterByType;
window.filterByBudget = filterByBudget;
window.filterByDuration = filterByDuration;