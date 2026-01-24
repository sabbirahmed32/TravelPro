// Global AJAX handlers and utility functions
class TravelApp {
    constructor() {
        this.init();
    }

    init() {
        this.setupAjaxDefaults();
        this.setupFormHandlers();
        this.setupFileUploads();
        this.setupNotifications();
    }

    setupAjaxDefaults() {
        // Set default headers for AJAX requests
        const token = document.querySelector('meta[name="csrf-token"]');
        if (token) {
            window.defaultHeaders = {
                'X-CSRF-TOKEN': token.getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            };
        }
    }

    setupFormHandlers() {
        // Handle AJAX form submissions
        document.addEventListener('submit', (e) => {
            const form = e.target;
            if (!form.hasAttribute('data-ajax')) return;

            e.preventDefault();
            this.submitAjaxForm(form);
        });
    }

    submitAjaxForm(form) {
        const submitBtn = form.querySelector('[type="submit"]');
        const originalText = submitBtn?.textContent;
        
        // Show loading state
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Processing...';
        }

        const formData = new FormData(form);
        const method = form.method || 'POST';
        const url = form.action;

        fetch(url, {
            method: method,
            headers: window.defaultHeaders,
            body: method === 'GET' ? new URLSearchParams(formData) : formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                this.showNotification(data.message || 'Success!', 'success');
                
                // Handle redirects
                if (data.redirect) {
                    setTimeout(() => {
                        window.location.href = data.redirect;
                    }, 1500);
                }
                
                // Handle form reset
                if (form.hasAttribute('data-reset-on-success')) {
                    form.reset();
                }
                
                // Trigger custom event
                const event = new CustomEvent('form:success', { detail: data });
                document.dispatchEvent(event);
            } else {
                this.showNotification(data.message || 'Error occurred', 'error');
                
                // Handle validation errors
                if (data.errors) {
                    this.showValidationErrors(form, data.errors);
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            this.showNotification('An error occurred. Please try again.', 'error');
        })
        .finally(() => {
            // Restore button state
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            }
        });
    }

    setupFileUploads() {
        // Handle file upload previews and validation
        document.addEventListener('change', (e) => {
            const input = e.target;
            if (!input.type === 'file' || !input.hasAttribute('data-preview')) return;

            this.handleFilePreview(input);
        });
    }

    handleFilePreview(input) {
        const files = input.files;
        const previewContainer = document.querySelector(input.getAttribute('data-preview'));
        
        if (!previewContainer) return;

        previewContainer.innerHTML = '';

        Array.from(files).forEach(file => {
            // Validate file type and size
            const maxSize = 5 * 1024 * 1024; // 5MB
            const allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
            
            if (!allowedTypes.includes(file.type)) {
                this.showNotification('Invalid file type. Only PDF, JPG, and PNG are allowed.', 'error');
                return;
            }
            
            if (file.size > maxSize) {
                this.showNotification('File size too large. Maximum size is 5MB.', 'error');
                return;
            }

            // Create preview element
            const preview = document.createElement('div');
            preview.className = 'relative inline-block m-2';
            
            if (file.type.startsWith('image/')) {
                const img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                img.className = 'w-20 h-20 object-cover rounded-lg border';
                preview.appendChild(img);
            } else {
                // PDF preview
                const pdfPreview = document.createElement('div');
                pdfPreview.className = 'w-20 h-20 bg-gray-100 rounded-lg border flex items-center justify-center';
                pdfPreview.innerHTML = `
                    <div class="text-center">
                        <i class="fas fa-file-pdf text-red-500 text-2xl"></i>
                        <p class="text-xs mt-1 truncate">${file.name}</p>
                    </div>
                `;
                preview.appendChild(pdfPreview);
            }
            
            // Add remove button
            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 text-xs';
            removeBtn.innerHTML = '<i class="fas fa-times"></i>';
            removeBtn.onclick = () => preview.remove();
            preview.appendChild(removeBtn);
            
            previewContainer.appendChild(preview);
        });
    }

    setupNotifications() {
        // Create notification container if it doesn't exist
        if (!document.getElementById('notifications')) {
            const container = document.createElement('div');
            container.id = 'notifications';
            container.className = 'fixed top-4 right-4 z-50 space-y-2';
            document.body.appendChild(container);
        }
    }

    showNotification(message, type = 'info') {
        const container = document.getElementById('notifications');
        const notification = document.createElement('div');
        
        const typeClasses = {
            success: 'bg-green-500',
            error: 'bg-red-500',
            warning: 'bg-yellow-500',
            info: 'bg-blue-500'
        };
        
        notification.className = `${typeClasses[type]} text-white px-6 py-4 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full`;
        notification.textContent = message;
        
        container.appendChild(notification);
        
        // Animate in
        setTimeout(() => {
            notification.classList.remove('translate-x-full');
        }, 100);
        
        // Remove after 5 seconds
        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 300);
        }, 5000);
    }

    showValidationErrors(form, errors) {
        // Clear previous errors
        form.querySelectorAll('.text-red-500').forEach(el => el.remove());
        form.querySelectorAll('.border-red-500').forEach(el => {
            el.classList.remove('border-red-500');
            el.classList.add('border-gray-300');
        });
        
        // Show new errors
        Object.keys(errors).forEach(fieldName => {
            const field = form.querySelector(`[name="${fieldName}"]`);
            if (field) {
                field.classList.remove('border-gray-300');
                field.classList.add('border-red-500');
                
                const errorDiv = document.createElement('div');
                errorDiv.className = 'text-red-500 text-sm mt-1';
                errorDiv.textContent = Array.isArray(errors[fieldName]) ? errors[fieldName][0] : errors[fieldName];
                
                field.parentNode.appendChild(errorDiv);
            }
        });
    }

    // Utility method to fetch data with proper headers
    fetchWithDefaults(url, options = {}) {
        const defaultOptions = {
            headers: {
                ...window.defaultHeaders,
                ...options.headers
            }
        };
        
        return fetch(url, { ...defaultOptions, ...options });
    }

    // Show loading spinner
    showLoading(element, message = 'Loading...') {
        element.disabled = true;
        element.dataset.originalText = element.textContent;
        element.innerHTML = `<i class="fas fa-spinner fa-spin mr-2"></i>${message}`;
    }

    // Hide loading spinner
    hideLoading(element) {
        element.disabled = false;
        element.textContent = element.dataset.originalText || element.textContent;
        delete element.dataset.originalText;
    }
}

// Initialize the application
const travelApp = new TravelApp();

// Export for global access
window.travelApp = travelApp;