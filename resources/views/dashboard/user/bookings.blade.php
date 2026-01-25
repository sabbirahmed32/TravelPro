@extends('layouts.dashboard')

@section('title', 'Bookings')

@section('header', 'Bookings')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-2xl font-semibold text-gray-900">Travel Bookings</h1>
            <p class="mt-1 text-sm text-gray-500">Manage your travel bookings and reservations</p>
        </div>

        <!-- Bookings List -->
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            @if($bookings->count() > 0)
                <ul class="divide-y divide-gray-200">
                    @foreach($bookings as $booking)
                        <li>
                            <div class="px-4 py-4 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center">
                                                <i class="fas fa-plane text-purple-600"></i>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $booking->package_name ?? 'Travel Package' }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $booking->destination ?? 'Unknown Destination' }} • 
                                                {{ $booking->travel_date ? $booking->travel_date->format('M d, Y') : 'Date not set' }}
                                            </div>
                                            @if($booking->total_amount)
                                                <div class="text-sm text-gray-500">
                                                    Total: ${{ number_format($booking->total_amount, 2) }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-800' : 
                                               ($booking->status === 'cancelled' ? 'bg-red-100 text-red-800' : 
                                               'bg-yellow-100 text-yellow-800') }}">
                                            {{ ucfirst($booking->status ?? 'pending') }}
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
                        @if($bookings->hasPages())
                            <a href="{{ $bookings->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Previous
                            </a>
                            <a href="{{ $bookings->nextPageUrl() }}" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Next
                            </a>
                        @endif
                    </div>
                    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm text-gray-700">
                                Showing
                                <span class="font-medium">{{ $bookings->firstItem() }}</span>
                                to
                                <span class="font-medium">{{ $bookings->lastItem() }}</span>
                                of
                                <span class="font-medium">{{ $bookings->total() }}</span>
                                results
                            </p>
                        </div>
                        <div>
                            {{ $bookings->links() }}
                        </div>
                    </div>
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No bookings</h3>
                    <p class="mt-1 text-sm text-gray-500">Get started by exploring our travel packages.</p>
                    <div class="mt-6">
                        <a href="{{ route('tours-holidays') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <i class="fas fa-search -ml-1 mr-2"></i>
                            Browse Travel Packages
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection