@extends('layouts.dashboard')

@section('title', 'Student Application Details')

@section('header', 'Student Application Details')

@section('content')
<!-- Include Alert Messages -->
@include('components.alert-messages')

<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                    <h1 class="text-2xl font-semibold text-gray-900">Student Application #{{ $studentApplication->id }}</h1>
                    <p class="mt-1 text-sm text-gray-500">Submitted on {{ $studentApplication->created_at->format('M d, Y g:i A') }}</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.student-applications') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
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
            <!-- Student Information -->
            <div class="lg:col-span-2 bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Student Information</h3>
                    
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Full Name</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $studentApplication->user->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Email Address</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $studentApplication->user->email }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Phone Number</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $studentApplication->user->phone ?? 'Not provided' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Date of Birth</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $studentApplication->date_of_birth ? $studentApplication->date_of_birth->format('M d, Y') : 'Not provided' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Passport Number</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $studentApplication->passport_number ?? 'Not provided' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Applied Date</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $studentApplication->created_at->format('M d, Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $studentApplication->updated_at->format('M d, Y g:i A') }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Academic Information -->
            <div>
                <!-- Status Card -->
                <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Application Status</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <span class="inline-flex items-center px-3 py-2 rounded-full text-sm font-medium
                                    {{ $studentApplication->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                       ($studentApplication->status === 'rejected' ? 'bg-red-100 text-red-800' : 
                                       ($studentApplication->status === 'processing' ? 'bg-blue-100 text-blue-800' :
                                       'bg-yellow-100 text-yellow-800')) }}">
                                    {{ ucfirst($studentApplication->status) }}
                                </span>
                            </div>
                            
                            @if($studentApplication->notes)
                                <div class="bg-gray-50 p-3 rounded-md">
                                    <h4 class="text-sm font-medium text-gray-900 mb-2">Admin Notes</h4>
                                    <p class="text-sm text-gray-700">{{ $studentApplication->notes }}</p>
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
                            <form method="POST" action="{{ route('admin.student-applications.status', $studentApplication) }}">
                                @csrf
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Update Status</label>
                                    <select id="status" name="status" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        <option value="pending" {{ $studentApplication->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="processing" {{ $studentApplication->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                        <option value="approved" {{ $studentApplication->status === 'approved' ? 'selected' : '' }}>Approved</option>
                                        <option value="rejected" {{ $studentApplication->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
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
                                <p class="mb-2"><strong>Application ID:</strong> #{{ $studentApplication->id }}</p>
                                <p class="mb-2"><strong>University:</strong> {{ $studentApplication->university_name ?? 'Not specified' }}</p>
                                <p class="mb-2"><strong>Course:</strong> {{ $studentApplication->course_name ?? 'Not specified' }}</p>
                                <p><strong>Application Fee:</strong> ${{ number_format($studentApplication->application_fee ?? 0, 2) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Documents Section -->
        @if($studentApplication->documents && $studentApplication->documents->count() > 0)
            <div class="bg-white shadow overflow-hidden sm:rounded-lg mt-6">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Submitted Documents</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($studentApplication->documents as $document)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex items-center mb-2">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                            <i class="fas fa-file-alt text-indigo-600"></i>
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
        </div>
    </div>
</div>
@endsection