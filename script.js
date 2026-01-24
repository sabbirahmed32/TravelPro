// Global variables
let currentLanguage = 'en';
let bookingData = {};
let toursData = [];
let hotelsData = [];
let flightsData = [];
let bookingsData = [];

// Multi-language translations
const translations = {
    en: {
        hero_title: "Discover Your Next Adventure",
        hero_subtitle: "Explore the world with our premium travel services and customized tour packages",
        explore_tours: "Explore Tours",
        get_quote: "Get Quote",
        tours: "Tours",
        hotels: "Hotels",
        flights: "Flights",
        destination: "Destination",
        checkin: "Check-in",
        checkout: "Check-out",
        search: "Search",
        featured_tours: "Featured Tours",
        premium_hotels: "Premium Hotels",
        flight_deals: "Flight Deals",
        about_title: "About Travel Business",
        about_description: "We are a leading travel agency dedicated to providing exceptional travel experiences worldwide. With over 15 years of experience, we specialize in creating customized tour packages that cater to your unique preferences and budget.",
        award_service: "Award Winning Service",
        safe_booking: "Safe & Secure Booking",
        support_24: "24/7 Customer Support",
        contact_title: "Get In Touch",
        address: "Address",
        phone: "Phone",
        email: "Email",
        send_message: "Send Message",
        complete_booking: "Complete Your Booking",
        full_name: "Full Name",
        number_travelers: "Number of Travelers",
        special_requests: "Special Requests",
        payment_information: "Payment Information",
        credit_card: "Credit Card",
        paypal: "PayPal",
        bank_transfer: "Bank Transfer",
        admin_panel: "Admin Panel",
        manage_tours: "Manage Tours",
        bookings: "Bookings",
        users: "Users"
    },
    bn: {
        hero_title: "আপনার পরবর্তী অ্যাডভেঞ্চার আবিষ্কার করুন",
        hero_subtitle: "আমাদের প্রিমিয়াম ভ্রমণ পরিষেবা এবং কাস্টমাইজড ট্যুর প্যাকেজ দিয়ে বিশ্ব অন্বেষণ করুন",
        explore_tours: "ট্যুর অন্বেষণ করুন",
        get_quote: "উদ্ধৃতি পান",
        tours: "ট্যুর",
        hotels: "হোটেল",
        flights: "ফ্লাইট",
        destination: "গন্তব্য",
        checkin: "চেক-ইন",
        checkout: "চেক-আউট",
        search: "অনুসন্ধান",
        featured_tours: "বৈশিষ্ট্যযুক্ত ট্যুর",
        premium_hotels: "প্রিমিয়াম হোটেল",
        flight_deals: "ফ্লাইট ডিল",
        about_title: "ট্রাভেল বিজনেস সম্পর্কে",
        about_description: "আমরা বিশ্বব্যাপী অসাধারণ ভ্রমণ অভিজ্ঞতা প্রদানের জন্য নিবেদিত একটি শীর্ষস্থানীয় ভ্রমণ সংস্থা। 15 বছরেরও বেশি অভিজ্ঞতা সহ, আমরা আপনার অনন্য পছন্দ এবং বাজেট অনুযায়ী কাস্টমাইজড ট্যুর প্যাকেজ তৈরি করতে বিশেষজ্ঞ।",
        award_service: "পুরস্কার বিজয়ী পরিষেবা",
        safe_booking: "নিরাপদ এবং সুরক্ষিত বুকিং",
        support_24: "২৪/৭ গ্রাহক সহায়তা",
        contact_title: "যোগাযোগ করুন",
        address: "ঠিকানা",
        phone: "ফোন",
        email: "ইমেল",
        send_message: "বার্তা পাঠান",
        complete_booking: "আপনার বুকিং সম্পূর্ণ করুন",
        full_name: "পূর্ণ নাম",
        number_travelers: "ভ্রমণকারীদের সংখ্যা",
        special_requests: "বিশেষ অনুরোধ",
        payment_information: "পেমেন্ট তথ্য",
        credit_card: "ক্রেডিট কার্ড",
        paypal: "পেপ্যাল",
        bank_transfer: "ব্যাংক ট্রান্সফার",
        admin_panel: "অ্যাডমিন প্যানেল",
        manage_tours: "ট্যুর পরিচালনা করুন",
        bookings: "বুকিং",
        users: "ব্যবহারকারী"
    },
    hi: {
        hero_title: "अपना अगला रोमांच खोजें",
        hero_subtitle: "हमारी प्रीमियम यात्रा सेवाओं और अनुकूलित टूर पैकेज के साथ दुनिया का अन्वेषण करें",
        explore_tours: "टूर अन्वेषण करें",
        get_quote: "उद्धरण प्राप्त करें",
        tours: "टूर",
        hotels: "होटल",
        flights: "उड़ानें",
        destination: "गंतव्य",
        checkin: "चेक-इन",
        checkout: "चेक-आउट",
        search: "खोजें",
        featured_tours: "विशेष टूर",
        premium_hotels: "प्रीमियम होटल",
        flight_deals: "उड़ान सौदे",
        about_title: "ट्रैवल बिजनेस के बारे में",
        about_description: "हम दुनिया भर में असाधारण यात्रा अनुभव प्रदान करने के लिए समर्पित एक प्रमुख यात्रा एजेंसी हैं। 15 से अधिक वर्षों के अनुभव के साथ, हम आपकी अनूठी प्राथमिकताओं और बजट के अनुसार अनुकूलित टूर पैकेज बनाने में विशेषज्ञ हैं।",
        award_service: "पुरस्कार विजेता सेवा",
        safe_booking: "सुरक्षित बुकिंग",
        support_24: "24/7 ग्राहक सहायता",
        contact_title: "संपर्क करें",
        address: "पता",
        phone: "फोन",
        email: "ईमेल",
        send_message: "संदेश भेजें",
        complete_booking: "अपनी बुकिंग पूरी करें",
        full_name: "पूरा नाम",
        number_travelers: "यात्रियों की संख्या",
        special_requests: "विशेष अनुरोध",
        payment_information: "भुगतान जानकारी",
        credit_card: "क्रेडिट कार्ड",
        paypal: "पेपैल",
        bank_transfer: "बैंक ट्रांसफर",
        admin_panel: "एडमिन पैनल",
        manage_tours: "टूर प्रबंधित करें",
        bookings: "बुकिंग",
        users: "उपयोगकर्ता"
    }
};

// Sample data
const sampleTours = [
    {
        id: 1,
        title: "Paris Romantic Getaway",
        description: "Experience the city of love with our exclusive Paris tour package",
        price: 1299,
        duration: "5 Days / 4 Nights",
        image: "https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?w=400",
        badge: "Popular",
        features: ["Hotel", "Flights", "Guide", "Meals"]
    },
    {
        id: 2,
        title: "Bali Tropical Paradise",
        description: "Discover the magical island of Bali with pristine beaches and temples",
        price: 999,
        duration: "7 Days / 6 Nights",
        image: "https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=400",
        badge: "Best Seller",
        features: ["Hotel", "Transfers", "Activities"]
    },
    {
        id: 3,
        title: "Swiss Alps Adventure",
        description: "Explore the breathtaking Swiss Alps with skiing and mountain activities",
        price: 1599,
        duration: "6 Days / 5 Nights",
        image: "https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=400",
        badge: "Adventure",
        features: ["Hotel", "Ski Pass", "Guide"]
    }
];

const sampleHotels = [
    {
        id: 1,
        name: "Grand Plaza Hotel",
        location: "New York, USA",
        price: 299,
        rating: 4.8,
        image: "https://images.unsplash.com/photo-1566073771259-6a8506099945?w=400",
        amenities: ["WiFi", "Pool", "Spa", "Gym"]
    },
    {
        id: 2,
        name: "Tropical Resort & Spa",
        location: "Maldives",
        price: 599,
        rating: 4.9,
        image: "https://images.unsplash.com/photo-1552728089-57bdde3e6b7b?w=400",
        amenities: ["Beach", "Diving", "Restaurant", "Bar"]
    }
];

const sampleFlights = [
    {
        id: 1,
        airline: "Emirates",
        from: "DHK",
        to: "DXB",
        departure: "10:00",
        arrival: "14:30",
        price: 450,
        duration: "4h 30m",
        class: "Economy"
    },
    {
        id: 2,
        airline: "Qatar Airways",
        from: "DHK",
        to: "DOH",
        departure: "15:00",
        arrival: "18:15",
        price: 380,
        duration: "3h 15m",
        class: "Business"
    }
];

// Initialize the application
document.addEventListener('DOMContentLoaded', function() {
    initializeApp();
});

function initializeApp() {
    loadSampleData();
    setupEventListeners();
    setupLanguageSelector();
    renderTours();
    renderHotels();
    renderFlights();
    setupSearchTabs();
    setupAdminPanel();
    setupBookingModal();
    setupPaymentGateway();
}

// Load sample data
function loadSampleData() {
    toursData = [...sampleTours];
    hotelsData = [...sampleHotels];
    flightsData = [...sampleFlights];
    
    // Load from localStorage if available
    const savedTours = localStorage.getItem('toursData');
    const savedHotels = localStorage.getItem('hotelsData');
    const savedFlights = localStorage.getItem('flightsData');
    const savedBookings = localStorage.getItem('bookingsData');
    
    if (savedTours) toursData = JSON.parse(savedTours);
    if (savedHotels) hotelsData = JSON.parse(savedHotels);
    if (savedFlights) flightsData = JSON.parse(savedFlights);
    if (savedBookings) bookingsData = JSON.parse(savedBookings);
}

// Setup event listeners
function setupEventListeners() {
    // Mobile navigation
    const navToggle = document.querySelector('.nav-toggle');
    const navMenu = document.querySelector('.nav-menu');
    
    if (navToggle && navMenu) {
        navToggle.addEventListener('click', () => {
            navMenu.classList.toggle('active');
            navToggle.classList.toggle('active');
        });
    }
    
    // Contact form
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', handleContactForm);
    }
    
    // Newsletter form
    const newsletterForm = document.querySelector('.newsletter-form');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', handleNewsletterForm);
    }
    
    // Smooth scrolling
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });
}

// Language selector
function setupLanguageSelector() {
    const languageSelect = document.getElementById('languageSelect');
    if (languageSelect) {
        languageSelect.value = currentLanguage;
        languageSelect.addEventListener('change', changeLanguage);
    }
}

function changeLanguage() {
    const languageSelect = document.getElementById('languageSelect');
    currentLanguage = languageSelect.value;
    
    // Update all translatable elements
    document.querySelectorAll('[data-translate]').forEach(element => {
        const key = element.getAttribute('data-translate');
        if (translations[currentLanguage][key]) {
            element.textContent = translations[currentLanguage][key];
        }
    });
    
    // Update placeholders
    document.querySelectorAll('[data-translate-placeholder]').forEach(element => {
        const key = element.getAttribute('data-translate-placeholder');
        if (translations[currentLanguage][key]) {
            element.placeholder = translations[currentLanguage][key];
        }
    });
    
    localStorage.setItem('currentLanguage', currentLanguage);
}

// Render tours
function renderTours() {
    const toursGrid = document.getElementById('toursGrid');
    if (!toursGrid) return;
    
    toursGrid.innerHTML = '';
    
    toursData.forEach(tour => {
        const tourCard = createTourCard(tour);
        toursGrid.appendChild(tourCard);
    });
}

function createTourCard(tour) {
    const card = document.createElement('div');
    card.className = 'tour-card';
    card.innerHTML = `
        <div class="card-image">
            <img src="${tour.image}" alt="${tour.title}">
            <div class="card-badge">${tour.badge}</div>
        </div>
        <div class="card-content">
            <h3 class="card-title">${tour.title}</h3>
            <p class="card-description">${tour.description}</p>
            <div class="card-details">
                <div class="card-price">$${tour.price}</div>
                <div class="card-duration">${tour.duration}</div>
            </div>
            <div class="card-features">
                ${tour.features.map(feature => `<span class="feature-tag">${feature}</span>`).join('')}
            </div>
            <button class="book-btn" onclick="openBookingModal('tour', ${tour.id})">Book Now</button>
        </div>
    `;
    return card;
}

// Render hotels
function renderHotels() {
    const hotelsGrid = document.getElementById('hotelsGrid');
    if (!hotelsGrid) return;
    
    hotelsGrid.innerHTML = '';
    
    hotelsData.forEach(hotel => {
        const hotelCard = createHotelCard(hotel);
        hotelsGrid.appendChild(hotelCard);
    });
}

function createHotelCard(hotel) {
    const card = document.createElement('div');
    card.className = 'hotel-card';
    card.innerHTML = `
        <div class="card-image">
            <img src="${hotel.image}" alt="${hotel.name}">
            <div class="card-badge">⭐ ${hotel.rating}</div>
        </div>
        <div class="card-content">
            <h3 class="card-title">${hotel.name}</h3>
            <p class="card-description">${hotel.location}</p>
            <div class="card-details">
                <div class="card-price">$${hotel.price}/night</div>
            </div>
            <div class="card-features">
                ${hotel.amenities.map(amenity => `<span class="feature-tag">${amenity}</span>`).join('')}
            </div>
            <button class="book-btn" onclick="openBookingModal('hotel', ${hotel.id})">Book Now</button>
        </div>
    `;
    return card;
}

// Render flights
function renderFlights() {
    const flightsGrid = document.getElementById('flightsGrid');
    if (!flightsGrid) return;
    
    flightsGrid.innerHTML = '';
    
    flightsData.forEach(flight => {
        const flightCard = createFlightCard(flight);
        flightsGrid.appendChild(flightCard);
    });
}

function createFlightCard(flight) {
    const card = document.createElement('div');
    card.className = 'flight-card';
    card.innerHTML = `
        <div class="card-content">
            <h3 class="card-title">${flight.airline}</h3>
            <div class="flight-route">
                <div class="departure">
                    <strong>${flight.from}</strong>
                    <span>${flight.departure}</span>
                </div>
                <div class="flight-duration">${flight.duration}</div>
                <div class="arrival">
                    <strong>${flight.to}</strong>
                    <span>${flight.arrival}</span>
                </div>
            </div>
            <div class="card-details">
                <div class="card-price">$${flight.price}</div>
                <div class="card-class">${flight.class}</div>
            </div>
            <button class="book-btn" onclick="openBookingModal('flight', ${flight.id})">Book Now</button>
        </div>
    `;
    return card;
}

// Search functionality
function setupSearchTabs() {
    const tabButtons = document.querySelectorAll('.tab-btn');
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            tabButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
        });
    });
}

function searchTours() {
    const destination = document.getElementById('destination').value;
    const checkin = document.getElementById('checkin').value;
    const checkout = document.getElementById('checkout').value;
    const guests = document.getElementById('guests').value;
    
    if (!destination) {
        showNotification('Please enter a destination', 'error');
        return;
    }
    
    // Simulate search
    showNotification('Searching for available tours...', 'info');
    
    setTimeout(() => {
        scrollToSection('tours');
        showNotification(`Found ${toursData.length} tours to ${destination}`, 'success');
    }, 1500);
}

function scrollToSection(sectionId) {
    const section = document.getElementById(sectionId);
    if (section) {
        section.scrollIntoView({ behavior: 'smooth' });
    }
}

// Admin Panel
function setupAdminPanel() {
    const adminBtn = document.querySelector('.admin-btn');
    if (adminBtn) {
        adminBtn.addEventListener('click', toggleAdminPanel);
    }
    
    // Admin tabs
    const adminTabButtons = document.querySelectorAll('.admin-tab-btn');
    adminTabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const tabName = this.getAttribute('data-admin-tab');
            showAdminTab(tabName);
        });
    });
}

function toggleAdminPanel() {
    const adminPanel = document.getElementById('adminPanel');
    if (adminPanel) {
        adminPanel.style.display = adminPanel.style.display === 'none' ? 'flex' : 'none';
        if (adminPanel.style.display === 'flex') {
            loadAdminData();
        }
    }
}

function showAdminTab(tabName) {
    const tabButtons = document.querySelectorAll('.admin-tab-btn');
    const tabContents = document.querySelectorAll('.admin-tab-content');
    
    tabButtons.forEach(btn => btn.classList.remove('active'));
    tabContents.forEach(content => content.classList.remove('active'));
    
    const activeButton = document.querySelector(`[data-admin-tab="${tabName}"]`);
    const activeContent = document.getElementById(`admin${tabName.charAt(0).toUpperCase() + tabName.slice(1)}`);
    
    if (activeButton) activeButton.classList.add('active');
    if (activeContent) activeContent.classList.add('active');
}

function loadAdminData() {
    loadToursList();
    loadBookingsList();
    loadUsersList();
}

function loadToursList() {
    const toursList = document.getElementById('toursList');
    if (!toursList) return;
    
    toursList.innerHTML = '';
    
    toursData.forEach(tour => {
        const tourItem = document.createElement('div');
        tourItem.className = 'admin-item';
        tourItem.innerHTML = `
            <div>
                <strong>${tour.title}</strong>
                <span> - $${tour.price}</span>
            </div>
            <div class="admin-item-actions">
                <button class="edit-btn" onclick="editTour(${tour.id})">Edit</button>
                <button class="delete-btn" onclick="deleteTour(${tour.id})">Delete</button>
            </div>
        `;
        toursList.appendChild(tourItem);
    });
}

function loadBookingsList() {
    const bookingsList = document.getElementById('bookingsList');
    if (!bookingsList) return;
    
    bookingsList.innerHTML = '';
    
    if (bookingsData.length === 0) {
        bookingsList.innerHTML = '<p>No bookings yet</p>';
        return;
    }
    
    bookingsData.forEach(booking => {
        const bookingItem = document.createElement('div');
        bookingItem.className = 'admin-item';
        bookingItem.innerHTML = `
            <div>
                <strong>${booking.name}</strong>
                <span> - ${booking.type} - $${booking.price}</span>
            </div>
            <div class="admin-item-actions">
                <button class="edit-btn" onclick="viewBooking(${booking.id})">View</button>
                <button class="delete-btn" onclick="deleteBooking(${booking.id})">Delete</button>
            </div>
        `;
        bookingsList.appendChild(bookingItem);
    });
}

function loadUsersList() {
    const usersList = document.getElementById('usersList');
    if (!usersList) return;
    
    usersList.innerHTML = '<p>User management features coming soon</p>';
}

function showAddTourForm() {
    // Implementation for adding new tour
    showNotification('Add tour form - Feature coming soon', 'info');
}

function editTour(tourId) {
    showNotification(`Edit tour ${tourId} - Feature coming soon`, 'info');
}

function deleteTour(tourId) {
    if (confirm('Are you sure you want to delete this tour?')) {
        toursData = toursData.filter(tour => tour.id !== tourId);
        localStorage.setItem('toursData', JSON.stringify(toursData));
        renderTours();
        loadToursList();
        showNotification('Tour deleted successfully', 'success');
    }
}

function viewBooking(bookingId) {
    showNotification(`View booking ${bookingId} - Feature coming soon`, 'info');
}

function deleteBooking(bookingId) {
    if (confirm('Are you sure you want to delete this booking?')) {
        bookingsData = bookingsData.filter(booking => booking.id !== bookingId);
        localStorage.setItem('bookingsData', JSON.stringify(bookingsData));
        loadBookingsList();
        showNotification('Booking deleted successfully', 'success');
    }
}

// Booking Modal
function setupBookingModal() {
    const bookingForm = document.getElementById('bookingForm');
    if (bookingForm) {
        bookingForm.addEventListener('submit', handleBookingSubmit);
    }
}

function openBookingModal(type, id) {
    const modal = document.getElementById('bookingModal');
    if (modal) {
        modal.classList.add('active');
        bookingData = { type, id };
    }
}

function closeBookingModal() {
    const modal = document.getElementById('bookingModal');
    if (modal) {
        modal.classList.remove('active');
    }
}

function handleBookingSubmit(e) {
    e.preventDefault();
    
    const formData = new FormData(e.target);
    const booking = {
        id: Date.now(),
        type: bookingData.type,
        itemId: bookingData.id,
        name: formData.get('name') || e.target.querySelector('input[type="text"]').value,
        email: formData.get('email') || e.target.querySelector('input[type="email"]').value,
        phone: formData.get('phone') || e.target.querySelector('input[type="tel"]').value,
        travelers: formData.get('travelers') || e.target.querySelector('input[type="number"]').value,
        requests: formData.get('requests') || e.target.querySelector('textarea').value,
        payment: formData.get('payment') || e.target.querySelector('input[name="payment"]:checked').value,
        timestamp: new Date().toISOString()
    };
    
    // Get price based on type and id
    let item;
    if (booking.type === 'tour') {
        item = toursData.find(t => t.id === booking.itemId);
    } else if (booking.type === 'hotel') {
        item = hotelsData.find(h => h.id === booking.itemId);
    } else if (booking.type === 'flight') {
        item = flightsData.find(f => f.id === booking.itemId);
    }
    
    booking.price = item ? item.price : 0;
    
    // Process payment
    processPayment(booking);
}

// Payment Gateway Integration
function setupPaymentGateway() {
    // Initialize Stripe (if available)
    if (typeof Stripe !== 'undefined') {
        // Stripe initialization would go here
        console.log('Stripe payment gateway ready');
    }
}

function processPayment(booking) {
    showNotification('Processing payment...', 'info');
    
    // Simulate payment processing
    setTimeout(() => {
        // Save booking
        bookingsData.push(booking);
        localStorage.setItem('bookingsData', JSON.stringify(bookingsData));
        
        // Close modal and show success
        closeBookingModal();
        showNotification('Booking completed successfully! Check your email for confirmation.', 'success');
        
        // Reset form
        const bookingForm = document.getElementById('bookingForm');
        if (bookingForm) {
            bookingForm.reset();
        }
    }, 2000);
}

// Form handlers
function handleContactForm(e) {
    e.preventDefault();
    
    const formData = new FormData(e.target);
    const name = e.target.querySelector('input[type="text"]').value;
    const email = e.target.querySelector('input[type="email"]').value;
    const message = e.target.querySelector('textarea').value;
    
    if (!name || !email || !message) {
        showNotification('Please fill in all required fields', 'error');
        return;
    }
    
    // Email validation
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        showNotification('Please enter a valid email address', 'error');
        return;
    }
    
    showNotification('Message sent successfully! We will get back to you soon.', 'success');
    e.target.reset();
}

function handleNewsletterForm(e) {
    e.preventDefault();
    
    const email = e.target.querySelector('input[type="email"]').value;
    
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        showNotification('Please enter a valid email address', 'error');
        return;
    }
    
    showNotification('Thank you for subscribing to our newsletter!', 'success');
    e.target.reset();
}

// Notification system
function showNotification(message, type = 'info') {
    const existingNotification = document.querySelector('.notification');
    if (existingNotification) {
        existingNotification.remove();
    }
    
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.textContent = message;
    
    notification.style.cssText = `
        position: fixed;
        top: 100px;
        right: 20px;
        padding: 1rem 1.5rem;
        border-radius: 10px;
        color: white;
        font-weight: 500;
        z-index: 10000;
        transform: translateX(100%);
        transition: transform 0.3s ease;
        max-width: 300px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    `;
    
    switch (type) {
        case 'success':
            notification.style.background = '#10b981';
            break;
        case 'error':
            notification.style.background = '#ef4444';
            break;
        default:
            notification.style.background = '#3b82f6';
    }
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);
    
    setTimeout(() => {
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 300);
    }, 3000);
}

// Mobile App Integration
function setupMobileAppIntegration() {
    // Check if running in mobile app context
    if (window.webkit && window.webkit.messageHandlers) {
        // iOS app integration
        window.webkit.messageHandlers.mobileApp.postMessage({
            type: 'website_loaded',
            data: { url: window.location.href }
        });
    } else if (window.Android) {
        // Android app integration
        window.Android.onWebsiteLoaded(window.location.href);
    }
    
    // Add mobile-specific features
    if ('serviceWorker' in navigator) {
        // Register service worker for PWA functionality
        navigator.serviceWorker.register('sw.js').then(function(registration) {
            console.log('ServiceWorker registration successful with scope: ', registration.scope);
        }).catch(function(err) {
            console.log('ServiceWorker registration failed: ', err);
        });
    }
}

// SEO Optimization
function setupSEO() {
    // Update meta tags dynamically
    const metaDescription = document.querySelector('meta[name="description"]');
    if (metaDescription) {
        metaDescription.content = translations[currentLanguage].hero_subtitle;
    }
    
    // Add structured data
    const structuredData = {
        "@context": "https://schema.org",
        "@type": "TravelAgency",
        "name": "Travel Business",
        "description": translations[currentLanguage].about_description,
        "url": window.location.href,
        "address": {
            "@type": "PostalAddress",
            "addressCountry": "Bangladesh"
        }
    };
    
    const script = document.createElement('script');
    script.type = 'application/ld+json';
    script.textContent = JSON.stringify(structuredData);
    document.head.appendChild(script);
}

// Performance optimizations
function setupPerformanceOptimizations() {
    // Lazy loading for images
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.style.opacity = '0';
                    img.addEventListener('load', () => {
                        img.style.transition = 'opacity 0.5s ease';
                        img.style.opacity = '1';
                    });
                    imageObserver.unobserve(img);
                }
            });
        });
        
        document.querySelectorAll('img').forEach(img => {
            imageObserver.observe(img);
        });
    }
}

// Initialize additional features
document.addEventListener('DOMContentLoaded', function() {
    setupMobileAppIntegration();
    setupSEO();
    setupPerformanceOptimizations();
});

// Console welcome message
console.log('%c🌍 Welcome to Travel Business!', 'color: #2563eb; font-size: 20px; font-weight: bold;');
console.log('%cPremium travel experiences await...', 'color: #6b7280; font-size: 14px;');