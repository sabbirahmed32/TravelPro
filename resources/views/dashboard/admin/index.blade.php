@extends('layouts.dashboard')

@section('title', 'Admin Dashboard')

@section('header', 'Admin Dashboard')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                                <i class="fas fa-users text-white"></i>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Users</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $stats['total_users'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-5 py-3">
                    <div class="text-sm">
                        <a href="{{ route('admin.users') }}" class="font-medium text-blue-700 hover:text-blue-600">Manage Users</a>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                                <i class="fas fa-passport text-white"></i>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Visa Applications</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $stats['total_visa_applications'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-5 py-3">
                    <div class="text-sm">
                        <span class="text-yellow-600 font-medium">{{ $stats['pending_visa_applications'] }} pending</span>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-purple-500 rounded-md flex items-center justify-center">
                                <i class="fas fa-graduation-cap text-white"></i>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Student Applications</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $stats['total_student_applications'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-5 py-3">
                    <div class="text-sm">
                        <span class="text-yellow-600 font-medium">{{ $stats['pending_student_applications'] }} pending</span>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                                <i class="fas fa-dollar-sign text-white"></i>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Revenue</dt>
                                <dd class="text-lg font-semibold text-gray-900">${{ number_format($stats['total_revenue'], 2) }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-5 py-3">
                    <div class="text-sm">
                        <span class="text-green-600 font-medium">${{ number_format($stats['this_month_revenue'], 2) }} this month</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Recent Visa Applications -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Recent Visa Applications</h3>
                        <a href="{{ route('admin.visa-applications') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">View all</a>
                    </div>
                    <div class="space-y-3">
                        @forelse ($recentVisaApplications as $application)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-passport text-blue-600"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">{{ $application->user->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $application->destination_country }} - {{ $application->visa_type }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-{{ $application->status_color }}-100 text-{{ $application->status_color }}-800">
                                        {{ ucfirst($application->status) }}
                                    </span>
                                    <button onclick="updateApplicationStatus('visa', '{{ $application->id }}')" class="text-indigo-600 hover:text-indigo-900">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">No visa applications yet</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Recent Student Applications -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Recent Student Applications</h3>
                        <a href="{{ route('admin.student-applications') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">View all</a>
                    </div>
                    <div class="space-y-3">
                        @forelse ($recentStudentApplications as $application)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-graduation-cap text-green-600"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">{{ $application->user->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $application->desired_course }} - {{ $application->target_country }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-{{ $application->status_color }}-100 text-{{ $application->status_color }}-800">
                                        {{ ucfirst($application->status) }}
                                    </span>
                                    <button onclick="updateApplicationStatus('student', '{{ $application->id }}')" class="text-indigo-600 hover:text-indigo-900">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">No student applications yet</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Recent Bookings -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Recent Bookings</h3>
                        <a href="{{ route('admin.bookings') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">View all</a>
                    </div>
                    <div class="space-y-3">
                        @forelse ($recentBookings as $booking)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-plane text-purple-600"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">{{ $booking->user->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $booking->booking_reference }} - ${{ number_format($booking->total_price, 2) }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-{{ $booking->status_color }}-100 text-{{ $booking->status_color }}-800">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                    <a href="{{ route('admin.bookings.show', $booking) }}" class="text-indigo-600 hover:text-indigo-900">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">No bookings yet</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Recent Consultations -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Recent Consultations</h3>
                        <a href="{{ route('admin.consultations') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">View all</a>
                    </div>
                    <div class="space-y-3">
                        @forelse ($recentConsultations as $consultation)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-comments text-yellow-600"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">{{ $consultation->user->name }}</p>
                                        <p class="text-xs text-gray-500">{{ ucfirst($consultation->consultation_type) }} - {{ $consultation->preferred_date_time->format('M d, Y') }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-{{ $consultation->status_color }}-100 text-{{ $consultation->status_color }}-800">
                                        {{ ucfirst($consultation->status) }}
                                    </span>
                                    <a href="{{ route('admin.consultations.show', $consultation) }}" class="text-indigo-600 hover:text-indigo-900">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">No consultations yet</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Quick Actions</h3>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <a href="{{ route('admin.visa-applications') }}" class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50">
                        <i class="fas fa-passport text-blue-600 mr-3"></i>
                        <span class="text-sm font-medium text-gray-900">Review Visa Applications</span>
                    </a>
                    <a href="{{ route('admin.student-applications') }}" class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50">
                        <i class="fas fa-graduation-cap text-green-600 mr-3"></i>
                        <span class="text-sm font-medium text-gray-900">Review Student Applications</span>
                    </a>
                    <a href="{{ route('admin.bookings') }}" class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50">
                        <i class="fas fa-plane text-purple-600 mr-3"></i>
                        <span class="text-sm font-medium text-gray-900">Manage Bookings</span>
                    </a>
                    <a href="{{ route('admin.analytics') }}" class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50">
                        <i class="fas fa-chart-line text-yellow-600 mr-3"></i>
                        <span class="text-sm font-medium text-gray-900">View Analytics</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Status Update Modal -->
<div id="statusModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeStatusModal()"></div>
        
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form id="statusForm" class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                @csrf
                <input type="hidden" id="applicationId" name="id">
                <input type="hidden" id="applicationType" name="type">
                
                <div class="mb-4">
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select id="status" name="status" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="pending">Pending</option>
                        <option value="under_review">Under Review</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>
                
                <div class="mb-4">
                    <label for="admin_notes" class="block text-sm font-medium text-gray-700 mb-2">Admin Notes</label>
                    <textarea id="admin_notes" name="admin_notes" rows="3" 
                              class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                              placeholder="Add any notes..."></textarea>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeStatusModal()" 
                            class="bg-gray-300 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="bg-indigo-600 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Update Status
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function updateApplicationStatus(type, id) {
    document.getElementById('applicationType').value = type;
    document.getElementById('applicationId').value = id;
    document.getElementById('statusModal').classList.remove('hidden');
}

function closeStatusModal() {
    document.getElementById('statusModal').classList.add('hidden');
    document.getElementById('statusForm').reset();
}

document.getElementById('statusForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const type = formData.get('type');
    const id = formData.get('id');
    
    const url = type === 'visa' 
        ? `/admin/visa-applications/${id}/status`
        : `/admin/student-applications/${id}/status`;
    
    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
        body: JSON.stringify({
            status: formData.get('status'),
            admin_notes: formData.get('admin_notes')
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Application status updated successfully!', 'success');
            closeStatusModal();
            location.reload();
        } else {
            showNotification('Error updating status', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred', 'error');
    });
});

function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 p-4 rounded-md shadow-lg z-50 ${
        type === 'success' ? 'bg-green-500' : 'bg-red-500'
    } text-white`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
}

// Auto-refresh dashboard data
setInterval(() => {
    fetch('/admin/quick-stats')
        .then(response => response.json())
        .then(data => {
            // Update stats if needed
        });
}, 60000);
</script>
@endpush
@endsection