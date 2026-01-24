@extends('layouts.app')

@section('title', 'Privacy Policy - TravelPro')

@section('meta-description', 'Privacy Policy of TravelPro - How we collect, use, and protect your personal information.')

@section('content')
<section class="hero-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1 class="display-4 fw-bold mb-4">Privacy Policy</h1>
                <p class="lead">Your privacy is important to us</p>
            </div>
        </div>
    </div>
</section>

<section class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="card">
                    <div class="card-body p-5">
                        <h2 class="mb-4">Privacy Policy</h2>
                        <p class="text-muted mb-4">Last updated: {{ date('F j, Y') }}</p>
                        
                        <h3 class="mt-5 mb-3">Introduction</h3>
                        <p>TravelPro ("we," "us," or "our") is committed to protecting your privacy. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website and use our travel services.</p>
                        
                        <h3 class="mt-5 mb-3">Information We Collect</h3>
                        
                        <h4 class="mt-4 mb-2">Personal Information</h4>
                        <p>We may collect personal information that you voluntarily provide to us, including:</p>
                        <ul>
                            <li>Name, contact information (email, phone, address)</li>
                            <li>Passport and travel document details</li>
                            <li>Academic and professional information</li>
                            <li>Travel preferences and requirements</li>
                            <li>Payment information (processed securely through third-party providers)</li>
                            <li>Communication history and correspondence</li>
                        </ul>
                        
                        <h4 class="mt-4 mb-2">Automatically Collected Information</h4>
                        <p>When you visit our website, we may automatically collect:</p>
                        <ul>
                            <li>IP address and device information</li>
                            <li>Browser type and version</li>
                            <li>Pages visited and time spent on our website</li>
                            <li>Referral source and search terms</li>
                            <li>Cookies and similar tracking technologies</li>
                        </ul>
                        
                        <h3 class="mt-5 mb-3">How We Use Your Information</h3>
                        <p>We use the information we collect to:</p>
                        <ul>
                            <li>Provide and manage your travel services</li>
                            <li>Process visa applications and student admissions</li>
                            <li>Book tour packages and consultations</li>
                            <li>Communicate with you about your inquiries and services</li>
                            <li>Improve our website and services</li>
                            <li>Send marketing communications (with your consent)</li>
                            <li>Comply with legal obligations</li>
                        </ul>
                        
                        <h3 class="mt-5 mb-3">Information Sharing</h3>
                        <p>We do not sell, trade, or otherwise transfer your personal information to third parties without your consent, except as described in this policy:</p>
                        
                        <h4 class="mt-4 mb-2">Service Providers</h4>
                        <p>We may share information with trusted third-party service providers who assist us in:</p>
                        <ul>
                            <li>Payment processing</li>
                            <li>Email delivery and marketing automation</li>
                            <li>Website hosting and analytics</li>
                            <li>Travel booking and reservation systems</li>
                        </ul>
                        
                        <h4 class="mt-4 mb-2">Legal Requirements</h4>
                        <p>We may disclose your information when required by law, court order, or government regulation, or to protect our rights, property, or safety.</p>
                        
                        <h4 class="mt-4 mb-2">Business Transfers</h4>
                        <p>If TravelPro is involved in a merger, acquisition, or sale of assets, your information may be transferred as part of the transaction.</p>
                        
                        <h3 class="mt-5 mb-3">Data Security</h3>
                        <p>We implement appropriate security measures to protect your personal information:</p>
                        <ul>
                            <li>SSL encryption for data transmission</li>
                            <li>Secure payment processing through PCI-compliant providers</li>
                            <li>Access controls and authentication systems</li>
                            <li>Regular security audits and updates</li>
                            <li>Employee training on data protection</li>
                        </ul>
                        
                        <h3 class="mt-5 mb-3">Cookies and Tracking Technologies</h3>
                        <p>We use cookies and similar technologies to enhance your experience:</p>
                        
                        <h4 class="mt-4 mb-2">Types of Cookies</h4>
                        <ul>
                            <li><strong>Essential Cookies:</strong> Required for website functionality</li>
                            <li><strong>Performance Cookies:</strong> Help us understand how you use our website</li>
                            <li><strong>Functional Cookies:</strong> Remember your preferences</li>
                            <li><strong>Marketing Cookies:</strong> Used to deliver relevant advertisements</li>
                        </ul>
                        
                        <h4 class="mt-4 mb-2">Cookie Management</h4>
                        <p>You can control cookies through your browser settings. However, disabling cookies may affect website functionality.</p>
                        
                        <h3 class="mt-5 mb-3">Your Rights</h3>
                        <p>Depending on your location, you may have the following rights:</p>
                        <ul>
                            <li><strong>Access:</strong> Request a copy of your personal information</li>
                            <li><strong>Correction:</strong> Request correction of inaccurate information</li>
                            <li><strong>Deletion:</strong> Request deletion of your personal information</li>
                            <li><strong>Portability:</strong> Request transfer of your data to another service</li>
                            <li><strong>Objection:</strong> Object to processing of your information</li>
                            <li><strong>Restriction:</strong> Limit how we use your information</li>
                        </ul>
                        
                        <h3 class="mt-5 mb-3">Data Retention</h3>
                        <p>We retain your personal information only as long as necessary to:</p>
                        <ul>
                            <li>Fulfill the purposes for which it was collected</li>
                            <li>Comply with legal obligations</li>
                            <li>Resolve disputes and enforce agreements</li>
                            <li>Fraud detection and prevention</li>
                        </ul>
                        
                        <h3 class="mt-5 mb-3">International Data Transfers</h3>
                        <p>Your information may be transferred to and processed in countries other than your own. We ensure appropriate safeguards are in place to protect your data.</p>
                        
                        <h3 class="mt-5 mb-3">Children's Privacy</h3>
                        <p>Our services are not intended for individuals under 18 years of age. We do not knowingly collect personal information from children under 18.</p>
                        
                        <h3 class="mt-5 mb-3">Changes to This Policy</h3>
                        <p>We may update this Privacy Policy from time to time. We will notify you of any changes by:</p>
                        <ul>
                            <li>Posting the updated policy on our website</li>
                            <li>Sending email notifications</li>
                            <li>Website notifications</li>
                        </ul>
                        
                        <h3 class="mt-5 mb-3">Contact Us</h3>
                        <p>If you have questions about this Privacy Policy or how we handle your information, please contact us:</p>
                        
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <h5>Email</h5>
                                <p>privacy@travelpro.com</p>
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
                                <p>www.travelpro.com/privacy</p>
                            </div>
                        </div>
                        
                        <div class="mt-5 p-4 bg-light rounded">
                            <p class="mb-0"><strong>Consent:</strong> By using our website and services, you consent to the collection and use of your information as described in this Privacy Policy.</p>
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
}

.legal-content h4 {
    color: var(--dark-color);
    margin-top: 20px;
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