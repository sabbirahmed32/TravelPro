@extends('layouts.dashboard')

@section('title', 'User Dashboard')

@section('header', 'Dashboard')

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
                                <i class="fas fa-passport text-white"></i>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Pending Visa Applications</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $stats['pending_visa_applications'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-5 py-3">
                    <div class="text-sm">
                        <a href="{{ route('dashboard.user.visa-applications') }}" class="font-medium text-blue-700 hover:text-blue-600">View all</a>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                                <i class="fas fa-graduation-cap text-white"></i>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Pending Student Applications</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $stats['pending_student_applications'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-5 py-3">
                    <div class="text-sm">
                        <a href="{{ route('dashboard.user.student-applications') }}" class="font-medium text-green-700 hover:text-green-600">View all</a>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-purple-500 rounded-md flex items-center justify-center">
                                <i class="fas fa-plane text-white"></i>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Pending Bookings</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $stats['pending_bookings'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-5 py-3">
                    <div class="text-sm">
                        <a href="{{ route('dashboard.user.bookings') }}" class="font-medium text-purple-700 hover:text-purple-600">View all</a>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                                <i class="fas fa-comments text-white"></i>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Pending Consultations</dt>
                                <dd class="text-lg font-semibold text-gray-900">{{ $stats['pending_consultations'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-5 py-3">
                    <div class="text-sm">
                        <a href="{{ route('dashboard.user.consultations') }}" class="font-medium text-yellow-700 hover:text-yellow-600">View all</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Visa Applications -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Recent Visa Applications</h3>
                    <div class="space-y-3">
                        @forelse ($recentVisaApplications as $application)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-passport text-blue-600"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">{{ $application->first_name }} {{ $application->last_name }}</p>
                                        <p class="text-xs text-gray-500">{{ $application->destination_country }} - {{ $application->visa_type }}</p>
                                    </div>
                                </div>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-{{ $application->status_color }}-100 text-{{ $application->status_color }}-800">
                                    {{ ucfirst($application->status) }}
                                </span>
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
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Recent Student Applications</h3>
                    <div class="space-y-3">
                        @forelse ($recentStudentApplications as $application)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-graduation-cap text-green-600"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">{{ $application->first_name }} {{ $application->last_name }}</p>
                                        <p class="text-xs text-gray-500">{{ $application->desired_course }} - {{ $application->target_country }}</p>
                                    </div>
                                </div>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-{{ $application->status_color }}-100 text-{{ $application->status_color }}-800">
                                    {{ ucfirst($application->status) }}
                                </span>
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
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Recent Bookings</h3>
                    <div class="space-y-3">
                        @forelse ($recentBookings as $booking)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-plane text-purple-600"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">{{ $booking->travelPackage->title ?? 'Package' }}</p>
                                        <p class="text-xs text-gray-500">{{ $booking->booking_reference }} - {{ $booking->number_of_travelers }} travelers</p>
                                    </div>
                                </div>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-{{ $booking->status_color }}-100 text-{{ $booking->status_color }}-800">
                                    {{ ucfirst($booking->status) }}
                                </span>
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
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Recent Consultations</h3>
                    <div class="space-y-3">
                        @forelse ($recentConsultations as $consultation)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-comments text-yellow-600"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">{{ ucfirst($consultation->consultation_type) }} Consultation</p>
                                        <p class="text-xs text-gray-500">{{ $consultation->preferred_date_time->format('M d, Y') }}</p>
                                    </div>
                                </div>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-{{ $consultation->status_color }}-100 text-{{ $consultation->status_color }}-800">
                                    {{ ucfirst($consultation->status) }}
                                </span>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">No consultations yet</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Real-time updates
setInterval(() => {
    fetch('/user/analytics')
        .then(response => response.json())
        .then(data => {
            // Update dashboard stats if needed
        });
}, 30000);
</script>
@endpush
@endsection