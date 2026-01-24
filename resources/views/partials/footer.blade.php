<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
                <h5><i class="bi bi-globe-americas me-2"></i>TravelPro</h5>
                <p class="mb-3">Your trusted partner for all travel needs. We provide comprehensive visa services, student admissions, tour packages, and expert consultation.</p>
                <div class="social-links">
                    <a href="#" class="text-white me-3"><i class="bi bi-facebook fs-5"></i></a>
                    <a href="#" class="text-white me-3"><i class="bi bi-twitter fs-5"></i></a>
                    <a href="#" class="text-white me-3"><i class="bi bi-instagram fs-5"></i></a>
                    <a href="#" class="text-white me-3"><i class="bi bi-linkedin fs-5"></i></a>
                </div>
            </div>
            
            <div class="col-lg-2 col-md-6 mb-4">
                <h5>Quick Links</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="{{ url('/') }}">Home</a></li>
                    <li class="mb-2"><a href="{{ url('/about') }}">About Us</a></li>
                    <li class="mb-2"><a href="{{ url('/visa-services') }}">Visa Services</a></li>
                    <li class="mb-2"><a href="{{ url('/student-admission') }}">Student Admission</a></li>
                    <li class="mb-2"><a href="{{ url('/tours-holidays') }}">Tours & Holidays</a></li>
                </ul>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4">
                <h5>Services</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="{{ url('/visa-services') }}">Tourist Visa</a></li>
                    <li class="mb-2"><a href="{{ url('/visa-services') }}">Student Visa</a></li>
                    <li class="mb-2"><a href="{{ url('/visa-services') }}">Work Visa</a></li>
                    <li class="mb-2"><a href="{{ url('/student-admission') }}">University Admission</a></li>
                    <li class="mb-2"><a href="{{ url('/consultation') }}">Travel Consultation</a></li>
                </ul>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4">
                <h5>Contact Info</h5>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <i class="bi bi-geo-alt me-2"></i>
                        123 Travel Street, City, Country
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-telephone me-2"></i>
                        +1 234 567 8900
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-envelope me-2"></i>
                        info@travelpro.com
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-clock me-2"></i>
                        Mon - Fri: 9:00 AM - 6:00 PM
                    </li>
                </ul>
            </div>
        </div>
        
        <hr class="my-4 bg-secondary">
        
        <div class="row align-items-center">
            <div class="col-md-6">
                <p class="mb-0">&copy; {{ date('Y') }} TravelPro. All rights reserved.</p>
            </div>
            <div class="col-md-6 text-md-end">
                <a href="{{ url('/privacy-policy') }}" class="text-white me-3">Privacy Policy</a>
                <a href="{{ url('/terms-of-service') }}" class="text-white me-3">Terms of Service</a>
                <a href="{{ url('/refund-policy') }}" class="text-white">Refund Policy</a>
            </div>
        </div>
    </div>
</footer>