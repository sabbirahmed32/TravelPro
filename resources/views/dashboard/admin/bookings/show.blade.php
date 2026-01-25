@extends('layouts.dashboard')

@section('title', 'Booking Details')

@section('header', 'Booking Details')

@section('content')
<!-- Include Alert Messages -->
@include('components.alert-messages')

<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                    <h1 class="text-2xl font-semibold text-gray-900">Booking #{{ $booking->id }}</h1>
                    <p class="mt-1 text-sm text-gray-500">Booked on {{ $booking->created_at->format('M d, Y g:i A') }}</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.bookings') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to List
                    </a>
                    <button onclick="window.print()" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <i class="fas fa-print mr-2"></i>
                        Print
                    </button>
                </div>
            </div>
        </div>

        <!-- Booking Details -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Customer Information -->
            <div class="lg:col-span-2 bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Customer Information</h3>
                    
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Full Name</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $booking->user->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Email Address</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $booking->user->email }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Phone Number</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $booking->user->phone ?? 'Not provided' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Address</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $booking->user->address ?? 'Not provided' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Booking Date</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $booking->created_at->format('M d, Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $booking->updated_at->format('M d, Y g:i A') }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Booking Details -->
            <div>
                <!-- Status Card -->
                <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Booking Status</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <span class="inline-flex items-center px-3 py-2 rounded-full text-sm font-medium
                                    {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-800' : 
                                       ($booking->status === 'cancelled' ? 'bg-red-100 text-red-800' : 
                                       'bg-yellow-100 text-yellow-800')) }}">
                                    {{ ucfirst($booking->status ?? 'pending') }}
                                </span>
                            </div>
                            
                            @if($booking->notes)
                                <div class="bg-gray-50 p-3 rounded-md">
                                    <h4 class="text-sm font-medium text-gray-900 mb-2">Admin Notes</h4>
                                    <p class="text-sm text-gray-700">{{ $booking->notes }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Quick Actions</h3>
                        
                        <div class="space-y-3">
                            @if($booking->status !== 'confirmed')
                                <form method="POST" action="{{ route('admin.bookings.confirm', $booking) }}">
                                    @csrf
                                    <div>
                                        <button type="submit" class="w-full bg-green-600 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                            <i class="fas fa-check mr-2"></i>
                                            Confirm Booking
                                        </button>
                                    </div>
                                </form>
                            @endif
                            
                            @if($booking->status !== 'cancelled')
                                <form method="POST" action="{{ route('admin.bookings.cancel', $booking) }}" onsubmit="return confirm('Are you sure you want to cancel this booking?')" class="mt-4">
                                    @csrf
                                    <button type="submit" class="w-full bg-red-600 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        <i class="fas fa-times mr-2"></i>
                                        Cancel Booking
                                    </button>
                                </form>
                            @endif
                            
                            <hr class="my-4">
                            
                            <div class="text-sm text-gray-500">
                                <p class="mb-2"><strong>Booking ID:</strong> #{{ $booking->id }}</p>
                                <p class="mb-2"><strong>Package:</strong> {{ $booking->package_name ?? 'Custom Package' }}</p>
                                <p class="mb-2"><strong>Destination:</strong> {{ $booking->destination ?? 'Not specified' }}</p>
                                <p class="mb-2"><strong>Travel Date:</strong> {{ $booking->travel_date ? $booking->travel_date->format('M d, Y') : 'Not set' }}</p>
                                <p><strong>Total Amount:</strong> ${{ number_format($booking->total_amount ?? 0, 2) }}</p>
                                <p><strong>Booking Date:</strong> {{ $booking->created_at->format('M d, Y g:i A') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Travel Package Details -->
        @if($booking->travelPackage)
            <div class="bg-white shadow overflow-hidden sm:rounded-lg mt-6">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Travel Package Details</h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Package Name</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $booking->travelPackage->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Description</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $booking->travelPackage->description ?? 'No description available' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Duration</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $booking->travelPackage->duration ?? 'Not specified' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Price</dt>
                            <dd class="mt-1 text-sm text-gray-900">$ {{ number_format($booking->travelPackage->price ?? 0, 2) }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Inclusions</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $booking->travelPackage->inclusions ?? 'Not specified' }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        @endif

        <!-- Payment History -->
        @if($booking->payments && $booking->payments->count() > 0)
            <div class="bg-white shadow overflow-hidden sm:rounded-lg mt-6">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Payment History</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Method</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($booking->payments as $payment)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            ${{ number_format($payment->amount, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $payment->method ?? 'Unknown' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $payment->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                {{ $payment->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                                       ($payment->status === 'failed' ? 'bg-red-100 text-red-800' : 
                                                       'bg-yellow-100 text-yellow-800') }}">
                                                {{ ucfirst($payment->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
        </div>
    </div>
</div>
@endsection