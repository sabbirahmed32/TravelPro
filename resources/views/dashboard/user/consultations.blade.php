@extends('layouts.dashboard')

@section('title', 'Consultations')

@section('header', 'Consultations')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-2xl font-semibold text-gray-900">Consultations</h1>
            <p class="mt-1 text-sm text-gray-500">Manage your consultation appointments and expert advice sessions</p>
        </div>

        <!-- Consultations List -->
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            @if($consultations->count() > 0)
                <ul class="divide-y divide-gray-200">
                    @foreach($consultations as $consultation)
                        <li>
                            <div class="px-4 py-4 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center">
                                                <i class="fas fa-comments text-yellow-600"></i>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $consultation->consultation_type ?? 'General Consultation' }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                @if($consultation->scheduled_date)
                                                    Scheduled for {{ $consultation->scheduled_date->format('M d, Y') }}
                                                    @if($consultation->scheduled_time)
                                                        at {{ $consultation->scheduled_time->format('g:i A') }}
                                                    @endif
                                                @else
                                                    Requested on {{ $consultation->created_at->format('M d, Y') }}
                                                @endif
                                            </div>
                                            @if($consultation->consultant_name)
                                                <div class="text-sm text-gray-500">
                                                    Consultant: {{ $consultation->consultant_name }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $consultation->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                               ($consultation->status === 'cancelled' ? 'bg-red-100 text-red-800' : 
                                               ($consultation->status === 'scheduled' ? 'bg-blue-100 text-blue-800' :
                                               'bg-yellow-100 text-yellow-800')) }}">
                                            {{ ucfirst($consultation->status ?? 'pending') }}
                                        </span>
                                        <a href="#" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>

                <!-- Pagination -->
                <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                    <div class="flex-1 flex justify-between sm:hidden">
                        @if($consultations->hasPages())
                            <a href="{{ $consultations->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Previous
                            </a>
                            <a href="{{ $consultations->nextPageUrl() }}" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Next
                            </a>
                        @endif
                    </div>
                    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm text-gray-700">
                                Showing
                                <span class="font-medium">{{ $consultations->firstItem() }}</span>
                                to
                                <span class="font-medium">{{ $consultations->lastItem() }}</span>
                                of
                                <span class="font-medium">{{ $consultations->total() }}</span>
                                results
                            </p>
                        </div>
                        <div>
                            {{ $consultations->links() }}
                        </div>
                    </div>
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No consultations</h3>
                    <p class="mt-1 text-sm text-gray-500">Get started by booking a consultation with our experts.</p>
                    <div class="mt-6">
                        <a href="{{ route('consultation') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <i class="fas fa-calendar-plus -ml-1 mr-2"></i>
                            Book Consultation
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection