// Application-specific form handlers
class ApplicationForms {
    constructor() {
        this.init();
    }

    init() {
        this.setupVisaApplicationForm();
        this.setupStudentApplicationForm();
        this.setupBookingForm();
        this.setupConsultationForm();
        this.setupStatusUpdateForms();
    }

    setupVisaApplicationForm() {
        const form = document.getElementById('visaApplicationForm');
        if (!form) return;

        // File upload handling
        const documentInput = form.querySelector('[name="documents[]"]');
        const previewContainer = document.getElementById('documentPreview');
        
        if (documentInput && previewContainer) {
            documentInput.addEventListener('change', (e) => {
                this.handleDocumentUpload(e.target, previewContainer);
            });
        }

        // Dynamic passport expiry validation
        const passportExpiry = form.querySelector('[name="passport_expiry"]');
        const travelDate = form.querySelector('[name="intended_travel_date"]');
        
        if (passportExpiry && travelDate) {
            travelDate.addEventListener('change', () => {
                this.validatePassportExpiry(passportExpiry, travelDate.value);
            });
        }

        // Form submission
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            this.submitVisaApplication(form);
        });
    }

    setupStudentApplicationForm() {
        const form = document.getElementById('studentApplicationForm');
        if (!form) return;

        // GPA validation
        const gpaInput = form.querySelector('[name="gpa"]');
        const educationLevel = form.querySelector('[name="education_level"]');
        
        if (gpaInput && educationLevel) {
            educationLevel.addEventListener('change', () => {
                this.updateGPAMax(gpaInput, educationLevel.value);
            });
        }

        // English test validation
        const englishTestType = form.querySelector('[name="english_test_type"]');
        const englishScore = form.querySelector('[name="english_score"]');
        
        if (englishTestType && englishScore) {
            englishTestType.addEventListener('change', () => {
                this.updateEnglishTestRange(englishScore, englishTestType.value);
            });
        }

        // Character counter for personal statement
        const personalStatement = form.querySelector('[name="personal_statement"]');
        const charCounter = document.getElementById('charCounter');
        
        if (personalStatement && charCounter) {
            personalStatement.addEventListener('input', () => {
                const remaining = 2000 - personalStatement.value.length;
                charCounter.textContent = `${personalStatement.value.length}/2000 characters`;
                charCounter.className = remaining < 100 ? 'text-red-500' : 'text-gray-500';
            });
        }

        form.addEventListener('submit', (e) => {
            e.preventDefault();
            this.submitStudentApplication(form);
        });
    }

    setupBookingForm() {
        const form = document.getElementById('bookingForm');
        if (!form) return;

        // Package selection
        const packageSelect = form.querySelector('[name="travel_package_id"]');
        const travelerCount = form.querySelector('[name="number_of_travelers"]');
        
        if (packageSelect) {
            packageSelect.addEventListener('change', (e) => {
                this.loadPackageDetails(e.target.value);
            });
        }

        // Traveler details dynamic fields
        if (travelerCount) {
            travelerCount.addEventListener('change', (e) => {
                this.generateTravelerFields(parseInt(e.target.value));
            });
        }

        form.addEventListener('submit', (e) => {
            e.preventDefault();
            this.submitBooking(form);
        });
    }

    setupConsultationForm() {
        const form = document.getElementById('consultationForm');
        if (!form) return;

        // Consultation type fee display
        const consultationType = form.querySelector('[name="consultation_type"]');
        const feeDisplay = document.getElementById('consultationFee');
        
        if (consultationType && feeDisplay) {
            consultationType.addEventListener('change', (e) => {
                this.updateConsultationFee(e.target.value, feeDisplay);
            });
        }

        // DateTime validation
        const preferredDateTime = form.querySelector('[name="preferred_date_time"]');
        
        if (preferredDateTime) {
            // Set min datetime to current datetime
            const now = new Date();
            now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
            preferredDateTime.min = now.toISOString().slice(0, 16);
        }

        form.addEventListener('submit', (e) => {
            e.preventDefault();
            this.submitConsultation(form);
        });
    }

    setupStatusUpdateForms() {
        // Status update forms in admin dashboard
        document.querySelectorAll('.status-update-form').forEach(form => {
            form.addEventListener('submit', (e) => {
                e.preventDefault();
                this.submitStatusUpdate(form);
            });
        });

        // Status change triggers
        document.querySelectorAll('[data-status-change]').forEach(trigger => {
            trigger.addEventListener('change', (e) => {
                this.handleStatusChange(e.target);
            });
        });
    }

    // Visa Application Methods
    submitVisaApplication(form) {
        const formData = new FormData(form);
        
        // Validate required documents
        const documents = formData.getAll('documents[]');
        if (documents.length === 0 || documents[0].name === '') {
            travelApp.showNotification('Please upload at least one document', 'error');
            return;
        }

        travelApp.fetchWithDefaults('/api/visa-applications', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                travelApp.showNotification('Visa application submitted successfully!', 'success');
                form.reset();
                document.getElementById('documentPreview').innerHTML = '';
                
                // Redirect to dashboard after 2 seconds
                setTimeout(() => {
                    window.location.href = '/dashboard/user';
                }, 2000);
            } else {
                travelApp.showNotification(data.message || 'Error submitting application', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            travelApp.showNotification('Error submitting application', 'error');
        });
    }

    handleDocumentUpload(input, container) {
        container.innerHTML = '';
        
        Array.from(input.files).forEach(file => {
            const fileItem = document.createElement('div');
            fileItem.className = 'flex items-center justify-between p-3 bg-gray-50 rounded-lg';
            
            const fileInfo = document.createElement('div');
            fileInfo.className = 'flex items-center';
            
            const icon = this.getFileIcon(file.type);
            fileInfo.innerHTML = `
                <i class="${icon} mr-3"></i>
                <div>
                    <p class="text-sm font-medium text-gray-900">${file.name}</p>
                    <p class="text-xs text-gray-500">${this.formatFileSize(file.size)}</p>
                </div>
            `;
            
            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'text-red-500 hover:text-red-700';
            removeBtn.innerHTML = '<i class="fas fa-times"></i>';
            removeBtn.onclick = () => {
                fileItem.remove();
                // Update file input
                const dt = new DataTransfer();
                const remainingFiles = Array.from(input.files).filter(f => f !== file);
                remainingFiles.forEach(f => dt.items.add(f));
                input.files = dt.files;
            };
            
            fileItem.appendChild(fileInfo);
            fileItem.appendChild(removeBtn);
            container.appendChild(fileItem);
        });
    }

    validatePassportExpiry(passportField, travelDate) {
        if (!travelDate) return;
        
        const travel = new Date(travelDate);
        const expiry = new Date(passportField.value);
        const sixMonthsAfterTravel = new Date(travel);
        sixMonthsAfterTravel.setMonth(sixMonthsAfterTravel.getMonth() + 6);
        
        if (expiry < sixMonthsAfterTravel) {
            passportField.setCustomValidity('Passport must be valid for at least 6 months after travel date');
            travelApp.showNotification('Passport must be valid for at least 6 months after intended travel date', 'warning');
        } else {
            passportField.setCustomValidity('');
        }
    }

    // Student Application Methods
    submitStudentApplication(form) {
        const formData = new FormData(form);
        
        travelApp.fetchWithDefaults('/api/student-applications', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                travelApp.showNotification('Student application submitted successfully!', 'success');
                form.reset();
                
                setTimeout(() => {
                    window.location.href = '/dashboard/user';
                }, 2000);
            } else {
                travelApp.showNotification(data.message || 'Error submitting application', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            travelApp.showNotification('Error submitting application', 'error');
        });
    }

    updateGPAMax(gpaInput, educationLevel) {
        const maxGPA = {
            'high_school': 4.0,
            'bachelors': 4.0,
            'masters': 4.0,
            'phd': 4.0
        };
        
        gpaInput.max = maxGPA[educationLevel] || 4.0;
        gpaInput.placeholder = `Max: ${maxGPA[educationLevel] || 4.0}`;
    }

    updateEnglishTestRange(scoreInput, testType) {
        const ranges = {
            'IELTS': { min: 0, max: 9.0, step: 0.5 },
            'TOEFL': { min: 0, max: 120, step: 1 },
            'PTE': { min: 0, max: 90, step: 1 }
        };
        
        const range = ranges[testType];
        if (range) {
            scoreInput.min = range.min;
            scoreInput.max = range.max;
            scoreInput.step = range.step;
            scoreInput.placeholder = `${range.min}-${range.max}`;
        }
    }

    // Booking Methods
    submitBooking(form) {
        const formData = new FormData(form);
        
        travelApp.fetchWithDefaults('/api/bookings', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                travelApp.showNotification('Booking created successfully!', 'success');
                
                // Redirect to payment or booking details
                setTimeout(() => {
                    window.location.href = `/user/bookings/${data.booking.id}`;
                }, 2000);
            } else {
                travelApp.showNotification(data.message || 'Error creating booking', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            travelApp.showNotification('Error creating booking', 'error');
        });
    }

    loadPackageDetails(packageId) {
        travelApp.fetchWithDefaults(`/api/travel-packages/${packageId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const package = data.package;
                // Update package details display
                document.getElementById('packageTitle').textContent = package.title;
                document.getElementById('packagePrice').textContent = `$${package.current_price}`;
                document.getElementById('packageDescription').textContent = package.description;
                document.getElementById('availableSlots').textContent = package.available_slots;
                
                // Update max travelers
                const travelerCount = document.querySelector('[name="number_of_travelers"]');
                if (travelerCount) {
                    travelerCount.max = package.available_slots;
                }
            }
        })
        .catch(error => {
            console.error('Error loading package details:', error);
        });
    }

    generateTravelerFields(count) {
        const container = document.getElementById('travelerDetails');
        if (!container) return;
        
        container.innerHTML = '';
        
        for (let i = 1; i <= count; i++) {
            const fieldset = document.createElement('fieldset');
            fieldset.className = 'border p-4 rounded-lg mb-4';
            fieldset.innerHTML = `
                <legend class="text-lg font-medium">Traveler ${i}</legend>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">First Name</label>
                        <input type="text" name="traveler_details[${i}][first_name]" required 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Last Name</label>
                        <input type="text" name="traveler_details[${i}][last_name]" required 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Date of Birth</label>
                        <input type="date" name="traveler_details[${i}][date_of_birth]" required 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Passport Number</label>
                        <input type="text" name="traveler_details[${i}][passport_number]" required 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nationality</label>
                        <input type="text" name="traveler_details[${i}][nationality]" required 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>
            `;
            container.appendChild(fieldset);
        }
    }

    // Consultation Methods
    submitConsultation(form) {
        const formData = new FormData(form);
        
        travelApp.fetchWithDefaults('/api/consultations', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                travelApp.showNotification('Consultation request submitted successfully!', 'success');
                form.reset();
                
                setTimeout(() => {
                    window.location.href = '/dashboard/user';
                }, 2000);
            } else {
                travelApp.showNotification(data.message || 'Error submitting request', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            travelApp.showNotification('Error submitting request', 'error');
        });
    }

    updateConsultationFee(type, displayElement) {
        const fees = {
            'visa': 50,
            'student_admission': 75,
            'travel_planning': 100,
            'general': 25
        };
        
        const fee = fees[type] || 0;
        displayElement.textContent = `$${fee}`;
    }

    // Status Update Methods
    submitStatusUpdate(form) {
        const formData = new FormData(form);
        const url = form.action;
        
        travelApp.fetchWithDefaults(url, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                travelApp.showNotification('Status updated successfully!', 'success');
                
                // Close modal if applicable
                const modal = form.closest('.fixed');
                if (modal) {
                    modal.classList.add('hidden');
                }
                
                // Reload page to show updates
                setTimeout(() => {
                    location.reload();
                }, 1500);
            } else {
                travelApp.showNotification(data.message || 'Error updating status', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            travelApp.showNotification('Error updating status', 'error');
        });
    }

    // Utility Methods
    getFileIcon(fileType) {
        if (fileType === 'application/pdf') {
            return 'fas fa-file-pdf text-red-500';
        } else if (fileType.startsWith('image/')) {
            return 'fas fa-file-image text-blue-500';
        }
        return 'fas fa-file text-gray-500';
    }

    formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new ApplicationForms();
});

// Export for global access
window.ApplicationForms = ApplicationForms;