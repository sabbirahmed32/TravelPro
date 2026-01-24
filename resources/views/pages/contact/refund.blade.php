@extends('layouts.app')

@section('title', 'Refund Policy - TravelPro')

@section('meta-description', 'Refund Policy of TravelPro - Clear guidelines for refunds and cancellations of our travel services.')

@section('content')
<section class="hero-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1 class="display-4 fw-bold mb-4">Refund Policy</h1>
                <p class="lead">Clear and transparent refund guidelines</p>
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
                        <h2 class="mb-4">Refund Policy</h2>
                        <p class="text-muted mb-4">Last updated: {{ date('F j, Y') }}</p>
                        
                        <div class="alert alert-info mb-4">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>Important:</strong> All refund requests must be submitted in writing via email to refunds@travelpro.com
                        </div>
                        
                        <h3 class="mt-5 mb-3">1. Consultation Services</h3>
                        
                        <div class="refund-table">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Cancellation Time</th>
                                        <th>Refund Amount</th>
                                        <th>Processing Fee</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>24+ hours before appointment</td>
                                        <td><span class="badge bg-success">100%</span></td>
                                        <td>No fee</td>
                                    </tr>
                                    <tr>
                                        <td>Less than 24 hours before appointment</td>
                                        <td><span class="badge bg-danger">0%</span></td>
                                        <td>Full amount retained</td>
                                    </tr>
                                    <tr>
                                        <td>No-show without notice</td>
                                        <td><span class="badge bg-danger">0%</span></td>
                                        <td>Full amount retained</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="alert alert-warning mt-3">
                            <strong>Note:</strong> Consultation fees can be rescheduled up to 24 hours before the original appointment time.
                        </div>
                        
                        <h3 class="mt-5 mb-3">2. Visa Services</h3>
                        
                        <div class="refund-table">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Service Stage</th>
                                        <th>Refund Amount</th>
                                        <th>Conditions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Before document submission</td>
                                        <td><span class="badge bg-warning">70%</span></td>
                                        <td>30% processing fee applies</td>
                                    </tr>
                                    <tr>
                                        <td>After document submission</td>
                                        <td><span class="badge bg-danger">0%</span></td>
                                        <td>No refund after submission</td>
                                    </tr>
                                    <tr>
                                        <td>Government fees</td>
                                        <td><span class="badge bg-danger">0%</span></td>
                                        <td>Non-refundable under any circumstances</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <h3 class="mt-5 mb-3">3. Student Admission Services</h3>
                        
                        <div class="refund-table">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Service Stage</th>
                                        <th>Refund Amount</th>
                                        <th>Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Before university application</td>
                                        <td><span class="badge bg-success">80%</span></td>
                                        <td>20% processing fee</td>
                                    </tr>
                                    <tr>
                                        <td>After university application submission</td>
                                        <td><span class="badge bg-warning">40%</span></td>
                                        <td>60% processing fee</td>
                                    </tr>
                                    <tr>
                                        <td>After receiving admission offer</td>
                                        <td><span class="badge bg-danger">0%</span></td>
                                        <td>No refund after offer</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <h3 class="mt-5 mb-3">4. Tour Package Services</h3>
                        
                        <div class="refund-table">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Cancellation Time</th>
                                        <th>Refund Amount</th>
                                        <th>Processing Fee</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>30+ days before travel</td>
                                        <td><span class="badge bg-success">90%</span></td>
                                        <td>10% processing fee</td>
                                    </tr>
                                    <tr>
                                        <td>15-29 days before travel</td>
                                        <td><span class="badge bg-warning">50%</span></td>
                                        <td>50% processing fee</td>
                                    </tr>
                                    <tr>
                                        <td>8-14 days before travel</td>
                                        <td><span class="badge bg-danger">25%</span></td>
                                        <td>75% processing fee</td>
                                    </tr>
                                    <tr>
                                        <td>Less than 7 days before travel</td>
                                        <td><span class="badge bg-danger">0%</span></td>
                                        <td>Full amount retained</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="alert alert-info mt-3">
                            <strong>Special Note:</strong> Some tour packages may have different cancellation terms. Please check specific package terms before booking.
                        </div>
                        
                        <h3 class="mt-5 mb-3">5. Refund Process</h3>
                        
                        <h4 class="mt-4 mb-2">5.1 Request Submission</h4>
                        <p>To request a refund:</p>
                        <ul>
                            <li>Send email to refunds@travelpro.com</li>
                            <li>Include your booking/application ID</li>
                            <li>Provide reason for cancellation</li>
                            <li>Attach supporting documents if applicable</li>
                        </ul>
                        
                        <h4 class="mt-4 mb-2">5.2 Processing Time</h4>
                        <p>Refunds are processed within:</p>
                        <ul>
                            <li>Consultations: 5-7 business days</li>
                            <li>Visa Services: 10-14 business days</li>
                            <li>Student Services: 14-21 business days</li>
                            <li>Tour Packages: 15-30 business days</li>
                        </ul>
                        
                        <h4 class="mt-4 mb-2">5.3 Refund Method</h4>
                        <p>Refunds are issued via:</p>
                        <ul>
                            <li>Original payment method (preferred)</li>
                            <li>Bank transfer (if original method unavailable)</li>
                            <li>Credit note for future services (upon request)</li>
                        </ul>
                        
                        <h3 class="mt-5 mb-3">6. Non-Refundable Items</h3>
                        <p>The following are generally non-refundable:</p>
                        <ul>
                            <li>Government and embassy fees</li>
                            <li>Third-party service charges</li>
                            <li>Travel insurance premiums</li>
                            <li>Expedited processing fees</li>
                            <li>Customization charges for tours</li>
                            <li>Visa application centers' service fees</li>
                        </ul>
                        
                        <h3 class="mt-5 mb-3">7. Special Circumstances</h3>
                        
                        <h4 class="mt-4 mb-2">7.1 Medical Emergencies</h4>
                        <p>In case of medical emergencies:</p>
                        <ul>
                            <li>Provide medical certificate from registered practitioner</li>
                            <li>Refunds considered on case-by-case basis</li>
                            <li>Processing fee may be waived</li>
                        </ul>
                        
                        <h4 class="mt-4 mb-2">7.2 Visa Rejection</h4>
                        <p>If visa is rejected due to no fault of applicant:</p>
                        <ul>
                            <li>50% refund of service fees</li>
                            <li>Valid rejection letter required</li>
                            <li>Government fees non-refundable</li>
                        </ul>
                        
                        <h4 class="mt-4 mb-2">7.3 Force Majeure</h4>
                        <p>In extraordinary circumstances:</p>
                        <ul>
                            <li>Full credit for future services</li>
                            <li>Valid for 12 months from issue date</li>
                            <li>Subject to availability</li>
                        </ul>
                        
                        <h3 class="mt-5 mb-3">8. Refund Exceptions</h3>
                        <p>No refunds will be provided in the following situations:</p>
                        <ul>
                            <li>Cancellations due to misrepresentation or fraud</li>
                            <li>Failure to provide required documents</li>
                            <li>Cancellations after service completion</li>
                            <li>No-show without prior notice</li>
                            <li>Failure to meet visa/interview deadlines</li>
                        </ul>
                        
                        <h3 class="mt-5 mb-3">9. Dispute Resolution</h3>
                        <p>If you disagree with our refund decision:</p>
                        <ol>
                            <li>Contact our customer support within 7 days of decision</li>
                            <li>Provide additional supporting documents</li>
                            <li>Request review by senior management</li>
                            <li>Final decision communicated within 14 days</li>
                        </ol>
                        
                        <h3 class="mt-5 mb-3">10. Refund Policy Updates</h3>
                        <p>We reserve the right to update this refund policy. Changes will be:</p>
                        <ul>
                            <li>Posted on our website</li>
                            <li>Emailed to registered customers</li>
                            <li>Effective 30 days after notification</li>
                        </ul>
                        
                        <div class="mt-5 p-4 bg-light rounded">
                            <h5 class="mb-3">Contact for Refunds</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Email:</strong> refunds@travelpro.com</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Phone:</strong> +1 234 567 8900 ext. 2</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Hours:</strong> Mon-Fri, 9AM-6PM EST</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Website:</strong> www.travelpro.com/refunds</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-5 p-4 bg-primary text-white rounded">
                            <p class="mb-0"><strong>Customer Commitment:</strong> We are committed to fair and transparent refund practices. If you have any questions about our refund policy, please don't hesitate to contact our customer support team.</p>
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
.refund-table {
    margin: 20px 0;
}

.refund-table .table {
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
}

.refund-table .table th {
    background: var(--primary-color);
    color: white;
    font-weight: 500;
    border: none;
}

.refund-table .table td {
    vertical-align: middle;
}

.alert {
    border-radius: 10px;
    border: none;
}

.alert-info {
    background: rgba(37, 99, 235, 0.1);
    color: var(--primary-color);
}

.alert-warning {
    background: rgba(245, 158, 11, 0.1);
    color: var(--accent-color);
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
    
    .refund-table .table {
        font-size: 0.9rem;
    }
}
</style>
@endpush