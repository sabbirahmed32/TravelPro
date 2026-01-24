@extends('layouts.app')

@section('title', 'Terms of Service - TravelPro')

@section('meta-description', 'Terms of Service of TravelPro - Legal terms and conditions for using our travel services.')

@section('content')
<section class="hero-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1 class="display-4 fw-bold mb-4">Terms of Service</h1>
                <p class="lead">Legal terms and conditions for using our services</p>
            </div>
        </div>
    </div>
</section>

<section class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="card">
                    <div class="card-body p-5 legal-content">
                        <h2 class="mb-4">Terms of Service</h2>
                        <p class="text-muted mb-4">Last updated: {{ date('F j, Y') }}</p>
                        
                        <h3 class="mt-5 mb-3">1. Acceptance of Terms</h3>
                        <p>By accessing and using TravelPro's website and services, you accept and agree to be bound by these Terms of Service. If you do not agree to these terms, please do not use our services.</p>
                        
                        <h3 class="mt-5 mb-3">2. Services Description</h3>
                        <p>TravelPro provides the following travel-related services:</p>
                        <ul>
                            <li>Visa application assistance and consultation</li>
                            <li>Student admission guidance and support</li>
                            <li>Tour package booking and planning</li>
                            <li>Travel consultation services</li>
                            <li>Document processing and verification</li>
                            <li>Pre-departure preparation and support</li>
                        </ul>
                        
                        <h3 class="mt-5 mb-3">3. User Responsibilities</h3>
                        <p>As a user of our services, you agree to:</p>
                        <ul>
                            <li>Provide accurate, complete, and current information</li>
                            <li>Submit authentic documents and materials</li>
                            <li>Make timely payments for services rendered</li>
                            <li>Follow all application guidelines and requirements</li>
                            <li>Communicate promptly with our team</li>
                            <li>Inform us of any changes in your circumstances</li>
                            <li>Comply with all applicable laws and regulations</li>
                        </ul>
                        
                        <h3 class="mt-5 mb-3">4. Payment Terms</h3>
                        
                        <h4 class="mt-4 mb-2">4.1 Service Fees</h4>
                        <p>All service fees are clearly communicated before service commencement. Fees vary based on service type, destination, and complexity.</p>
                        
                        <h4 class="mt-4 mb-2">4.2 Payment Schedule</h4>
                        <ul>
                            <li><strong>Consultation Services:</strong> Full payment required before appointment</li>
                            <li><strong>Visa Services:</strong> 50% advance, 50% upon submission</li>
                            <li><strong>Student Admission:</strong> 30% advance, 40% upon university application, 30% upon offer</li>
                            <li><strong>Tour Packages:</strong> 50% advance, 50% before travel date</li>
                        </ul>
                        
                        <h4 class="mt-4 mb-2">4.3 Payment Methods</h4>
                        <p>We accept various payment methods including credit/debit cards, bank transfers, and online payment platforms. All payments are processed securely.</p>
                        
                        <h3 class="mt-5 mb-3">5. Cancellation and Refund Policy</h3>
                        
                        <h4 class="mt-4 mb-2">5.1 Consultation Services</h4>
                        <ul>
                            <li>Cancellations 24+ hours before appointment: Full refund</li>
                            <li>Cancellations less than 24 hours: No refund</li>
                            <li>Rescheduling allowed up to 24 hours before appointment</li>
                        </ul>
                        
                        <h4 class="mt-4 mb-2">5.2 Visa and Student Services</h4>
                        <ul>
                            <li>Cancellations before document submission: 70% refund</li>
                            <li>Cancellations after document submission: No refund</li>
                            <li>Government fees are non-refundable</li>
                        </ul>
                        
                        <h4 class="mt-4 mb-2">5.3 Tour Packages</h4>
                        <ul>
                            <li>Cancellations 30+ days before travel: Full refund minus 10% processing fee</li>
                            <li>Cancellations 15-29 days before travel: 50% refund</li>
                            <li>Cancellations 8-14 days before travel: 25% refund</li>
                            <li>Cancellations less than 7 days before travel: No refund</li>
                        </ul>
                        
                        <h3 class="mt-5 mb-3">6. Service Limitations</h3>
                        <p>TravelPro provides assistance and guidance but does not:</p>
                        <ul>
                            <li>Guarantee visa approvals or university admissions</li>
                            <li>Control government processing times or decisions</li>
                            <li>Assume responsibility for travel disruptions beyond our control</li>
                            <li>Provide legal advice or representation</li>
                            <li>Act as a travel insurance provider</li>
                        </ul>
                        
                        <h3 class="mt-5 mb-3">7. Accuracy of Information</h3>
                        <p>You are responsible for the accuracy of all information provided to us. TravelPro is not liable for issues arising from incorrect or incomplete information.</p>
                        
                        <h3 class="mt-5 mb-3">8. Third-Party Services</h3>
                        <p>Our services may involve third-party providers such as airlines, hotels, and educational institutions. We are not responsible for the quality, safety, or performance of third-party services.</p>
                        
                        <h3 class="mt-5 mb-3">9. Intellectual Property</h3>
                        <p>All content, materials, and intellectual property on our website and in our services are owned by TravelPro or its licensors. You may not use, copy, or distribute our content without permission.</p>
                        
                        <h3 class="mt-5 mb-3">10. Confidentiality</h3>
                        <p>We agree to maintain the confidentiality of your personal information in accordance with our Privacy Policy. You agree not to share proprietary information about our services or processes.</p>
                        
                        <h3 class="mt-5 mb-3">11. Limitation of Liability</h3>
                        
                        <h4 class="mt-4 mb-2">11.1 Service Liability</h4>
                        <p>Our liability is limited to the fees paid for our services. We are not liable for:</p>
                        <ul>
                            <li>Consequential, indirect, or punitive damages</li>
                            <li>Loss of opportunities or income</li>
                            <li>Emotional distress or inconvenience</li>
                            <li>Third-party service failures</li>
                        </ul>
                        
                        <h4 class="mt-4 mb-2">11.2 Maximum Liability</h4>
                        <p>Our maximum liability under any circumstance shall not exceed the total fees paid by you for the specific service in question.</p>
                        
                        <h3 class="mt-5 mb-3">12. Force Majeure</h3>
                        <p>We are not liable for delays or failures to perform due to circumstances beyond our reasonable control, including but not limited to:</p>
                        <ul>
                            <li>Natural disasters and extreme weather</li>
                            <li>War, terrorism, or civil unrest</li>
                            <li>Government actions or restrictions</li>
                            <li>Pandemics or public health crises</li>
                            <li>Transportation disruptions</li>
                            <li>Technical failures or cyber attacks</li>
                        </ul>
                        
                        <h3 class="mt-5 mb-3">13. Dispute Resolution</h3>
                        
                        <h4 class="mt-4 mb-2">13.1 Good Faith Negotiation</h4>
                        <p>If you have a dispute with our services, we agree to first attempt to resolve it through good faith negotiations.</p>
                        
                        <h4 class="mt-4 mb-2">13.2 Arbitration</h4>
                        <p>If disputes cannot be resolved through negotiation, they may be resolved through binding arbitration in accordance with applicable laws.</p>
                        
                        <h3 class="mt-5 mb-3">14. Termination</h3>
                        
                        <h4 class="mt-4 mb-2">14.1 By User</h4>
                        <p>You may terminate your use of our services at any time by providing written notice. You remain responsible for all fees incurred up to termination.</p>
                        
                        <h4 class="mt-4 mb-2">14.2 By TravelPro</h4>
                        <p>We may suspend or terminate your access to our services if you violate these terms or engage in prohibited activities.</p>
                        
                        <h3 class="mt-5 mb-3">15. Prohibited Activities</h3>
                        <p>You agree not to:</p>
                        <ul>
                            <li>Provide false or misleading information</li>
                            <li>Use our services for illegal purposes</li>
                            <li>Attempt to compromise our systems or security</li>
                            <li>Interfere with other users' access to services</li>
                            <li>Reproduce or redistribute our proprietary materials</li>
                            <li>Violate any applicable laws or regulations</li>
                        </ul>
                        
                        <h3 class="mt-5 mb-3">16. Indemnification</h3>
                        <p>You agree to indemnify and hold harmless TravelPro, its affiliates, and employees from any claims, damages, or expenses arising from your use of our services or violation of these terms.</p>
                        
                        <h3 class="mt-5 mb-3">17. Governing Law</h3>
                        <p>These Terms of Service shall be governed by and construed in accordance with the laws of the jurisdiction where TravelPro is registered, without regard to conflict of law principles.</p>
                        
                        <h3 class="mt-5 mb-3">18. Modification of Terms</h3>
                        <p>We reserve the right to modify these terms at any time. Changes will be effective upon posting on our website. Continued use of our services constitutes acceptance of modified terms.</p>
                        
                        <h3 class="mt-5 mb-3">19. Severability</h3>
                        <p>If any provision of these terms is found to be unenforceable, the remaining provisions shall remain in full force and effect.</p>
                        
                        <h3 class="mt-5 mb-3">20. Entire Agreement</h3>
                        <p>These Terms of Service, along with our Privacy Policy, constitute the entire agreement between you and TravelPro regarding our services.</p>
                        
                        <h3 class="mt-5 mb-3">21. Contact Information</h3>
                        <p>For questions about these Terms of Service, please contact us:</p>
                        
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <h5>Email</h5>
                                <p>legal@travelpro.com</p>
                            </div>
                            <div class="col-md-6">
                                <h5>Phone</h5>
                                <p>+1 234 567 8900</p>
                            </div>
                            <div class="col-md-6">
                                <h5>Address</h5>
                                <p>123 Travel Street<br>New York, NY 10001<br>United States</p>
                            </div>
                            <div class="col-md-6">
                                <h5>Website</h5>
                                <p>www.travelpro.com/terms</p>
                            </div>
                        </div>
                        
                        <div class="mt-5 p-4 bg-light rounded">
                            <p class="mb-0"><strong>Acknowledgment:</strong> By using TravelPro's services, you acknowledge that you have read, understood, and agree to be bound by these Terms of Service.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
.legal-content {
    line-height: 1.8;
}

.legal-content h3 {
    color: var(--primary-color);
    border-bottom: 2px solid var(--primary-color);
    padding-bottom: 10px;
    margin-top: 40px;
}

.legal-content h4 {
    color: var(--dark-color);
    margin-top: 25px;
    font-size: 1.1rem;
}

.legal-content ul {
    margin-bottom: 20px;
}

.legal-content li {
    margin-bottom: 8px;
}

.card {
    border: none;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    border-radius: 15px;
}

@media (max-width: 768px) {
    .card-body {
        padding: 30px 20px !important;
    }
}
</style>
@endpush