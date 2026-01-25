@extends('layouts.dashboard')

@section('title', 'Manage Student Applications')

@section('header', 'Student Applications Management')

@section('content')
<!-- Include Alert Messages -->
@include('components.alert-messages')

<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Student Applications</h1>
                <p class="mt-1 text-sm text-gray-500">Manage all student admission applications</p>
            </div>
            <div>
                <button onclick="window.location.reload()" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <i class="fas fa-sync -ml-1 mr-2"></i>
                    Refresh
                </button>
            </div>
        </div>

        <!-- Search and Filters -->
        <div class="bg-white shadow rounded-lg mb-6">
            <div class="px-4 py-5 sm:p-6">
                <form method="GET" action="{{ route('admin.student-applications') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                            <input type="text" id="search" name="search" value="{{ request('search') }}" 
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                   placeholder="Search by name, email, university...">
                        </div>
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select id="status" name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="">All Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}">Pending</option>
                                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}">Processing</option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}">Approved</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}">Rejected</option>
                            </select>
                        </div>
                        <div>
                            <label for="university" class="block text-sm font-medium text-gray-700">University</label>
                            <input type="text" id="university" name="university" value="{{ request('university') }}" 
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                   placeholder="Filter by university...">
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="bg-gray-600 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                <i class="fas fa-search mr-2"></i>
                                Search
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Applications List -->
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            @if($applications->count() > 0)
                <div class="min-w-full divide-y divide-gray-200">
                    <div class="bg-gray-50 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <div class="grid grid-cols-8 gap-4">
                            <div>Student</div>
                            <div>University</div>
                            <div>Course</div>
                            <div>Applied Date</div>
                            <div>Documents</div>
                            <div>Status</div>
                            <div>Actions</div>
                        </div>
                    </div>
                    <div class="bg-white divide-y divide-gray-200">
                        @foreach($applications as $application)
                            <div class="px-6 py-4">
                                <div class="grid grid-cols-8 gap-4 items-center">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            @if($application->user->avatar)
                                                <img class="h-10 w-10 rounded-full" src="{{ asset('storage/' . $application->user->avatar) }}" alt="{{ $application->user->name }}">
                                            @else
                                                <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                                    <span class="text-gray-600 font-medium">{{ substr($application->user->name, 0, 1) }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $application->user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $application->user->email }}</div>
                                        </div>
                                    </div>
                                    <div class="text-sm text-gray-900">{{ $application->university_name ?? 'Not specified' }}</div>
                                    <div class="text-sm text-gray-500">{{ $application->course_name ?? 'Not specified' }}</div>
                                    <div class="text-sm text-gray-500">{{ $application->created_at->format('M d, Y') }}</div>
                                    <div class="text-sm text-gray-500">
                                        @if($application->documents)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                {{ $application->documents->count() }} files
                                            </span>
                                        @else
                                            <span class="text-gray-400">No documents</span>
                                        @endif
                                    </div>
                                    <div>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $application->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                               ($application->status === 'rejected' ? 'bg-red-100 text-red-800' : 
                                               ($application->status === 'processing' ? 'bg-blue-100 text-blue-800' :
                                               'bg-yellow-100 text-yellow-800')) }}">
                                            {{ ucfirst($application->status) }}
                                        </span>
                                    </div>
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.student-applications.show', $application) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                                            View
                                        </a>
                                        <form method="POST" action="{{ route('admin.student-applications.status', $application) }}" class="inline">
                                            @csrf
                                            <select name="status" onchange="this.form.submit()" class="text-sm border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                                <option value="pending" {{ $application->status === 'pending' ? 'selected' : '' }}">Pending</option>
                                                <option value="processing" {{ $application->status === 'processing' ? 'selected' : '' }}">Processing</option>
                                                <option value="approved" {{ $application->status === 'approved' ? 'selected' : '' }}>Approved</option>
                                                <option value="rejected" {{ $application->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                            </select>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Pagination -->
                <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                    <div class="flex-1 flex justify-between sm:hidden">
                        @if($applications->hasPages())
                            <a href="{{ $applications->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Previous
                            </a>
                            <a href="{{ $applications->nextPageUrl() }}" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Next
                            </a>
                        @endif
                    </div>
                    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm text-gray-700">
                                Showing
                                <span class="font-medium">{{ $applications->firstItem() }}</span>
                                to
                                <span class="font-medium">{{ $applications->lastItem() }}</span>
                                of
                                <span class="font-medium">{{ $applications->total() }}</span>
                                results
                            </p>
                        </div>
                        <div>
                            {{ $applications->links() }}
                        </div>
                    </div>
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.168 5 4.565 0l1.1 3.547h1.1l1.1 3.547c0 1.843 1.595 4.565 4.565zm1.929 3.657l-16 4.676a1 1 0 00-1.886.018L7.662 19.434c-.331.12-.578.276-.72.576l4.965-4.772c.184-.09.404-.09-.61.09h-.004a1 1 0 00-.404.018L2.15 13.525c-.233.097-.528.097-.816.097-.289 0-.596-.15-.796l4.62-4.649a1 1 0 00-.675-.718l-4.622 4.647a1 1 0 01-.678.679L2.15 16.53a1 1 0 00.675-.718l4.62-4.647z" clip-rule="evenodd" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No student applications found</h3>
                    <p class="mt-1 text-sm text-gray-500">Try adjusting your search or filter criteria.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection