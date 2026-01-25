@extends('layouts.dashboard')

@section('title', 'Visa Application Details')

@section('header', 'Visa Application Details')

@section('content')
<!-- Include Alert Messages -->
@include('components.alert-messages')

<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900">Visa Application #{{ $visaApplication->id }}</h1>
                    <p class="mt-1 text-sm text-gray-500">Submitted on {{ $visaApplication->created_at->format('M d, Y g:i A') }}</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.visa-applications') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
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

        <!-- Application Details -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Applicant Information -->
            <div class="lg:col-span-2 bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Applicant Information</h3>
                    
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Full Name</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $visaApplication->user->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Email Address</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $visaApplication->user->email }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Phone Number</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $visaApplication->user->phone ?? 'Not provided' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Address</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $visaApplication->user->address ?? 'Not provided' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Applied Date</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $visaApplication->created_at->format('M d, Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $visaApplication->updated_at->format('M d, Y g:i A') }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Status and Actions -->
            <div>
                <!-- Status Card -->
                <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Application Status</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <span class="inline-flex items-center px-3 py-2 rounded-full text-sm font-medium
                                    {{ $visaApplication->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                       ($visaApplication->status === 'rejected' ? 'bg-red-100 text-red-800' : 
                                       ($visaApplication->status === 'processing' ? 'bg-blue-100 text-blue-800' :
                                       'bg-yellow-100 text-yellow-800')) }}">
                                    {{ ucfirst($visaApplication->status) }}
                                </span>
                            </div>
                            
                            @if($visaApplication->notes)
                                <div class="bg-gray-50 p-3 rounded-md">
                                    <h4 class="text-sm font-medium text-gray-900 mb-2">Admin Notes</h4>
                                    <p class="text-sm text-gray-700">{{ $visaApplication->notes }}</p>
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
                            <form method="POST" action="{{ route('admin.visa-applications.status', $visaApplication) }}">
                                @csrf
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Update Status</label>
                                    <select id="status" name="status" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        <option value="pending" {{ $visaApplication->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="processing" {{ $visaApplication->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                        <option value="approved" {{ $visaApplication->status === 'approved' ? 'selected' : '' }}>Approved</option>
                                        <option value="rejected" {{ $visaApplication->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <button type="submit" class="w-full bg-indigo-600 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <i class="fas fa-sync mr-2"></i>
                                        Update Status
                                    </button>
                                </div>
                            </form>
                            
                            <hr class="my-4">
                            
                            <div class="text-sm text-gray-500">
                                <p class="mb-2"><strong>Application ID:</strong> #{{ $visaApplication->id }}</p>
                                <p><strong>Destination:</strong> {{ $visaApplication->destination_country ?? 'Not specified' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Documents Section -->
        @if($visaApplication->documents && $visaApplication->documents->count() > 0)
            <div class="bg-white shadow overflow-hidden sm:rounded-lg mt-6">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Submitted Documents</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($visaApplication->documents as $document)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex items-center mb-2">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                            <i class="fas fa-file text-indigo-600"></i>
                                        </div>
                                    </div>
                                    <div class="ml-3">
                                        <h4 class="text-sm font-medium text-gray-900">{{ $document->name }}</h4>
                                        <p class="text-xs text-gray-500">{{ $document->size ? number_format($document->size / 1024, 2) . ' MB' : 'Unknown size' }}</p>
                                    </div>
                                </div>
                                
                                <div class="flex justify-between items-center mt-2">
                                    <span class="text-xs text-gray-500">Uploaded: {{ $document->created_at->format('M d, Y g:i A') }}</span>
                                    <a href="{{ route('api.files.download', $document) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                                        <i class="fas fa-download mr-1"></i>
                                        Download
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        <!-- Payments Section -->
        @if($visaApplication->payments && $visaApplication->payments->count() > 0)
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
                                @foreach($visaApplication->payments as $payment)
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
            @endif
        </div>
    </div>
</div>
@endsection