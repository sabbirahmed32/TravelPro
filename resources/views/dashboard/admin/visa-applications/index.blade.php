@extends('layouts.dashboard')

@section('title', 'Manage Visa Applications')

@section('header', 'Visa Applications Management')

@section('content')
<!-- Include Alert Messages -->
@include('components.alert-messages')

<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Visa Applications</h1>
                <p class="mt-1 text-sm text-gray-500">Manage all visa applications and their status</p>
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
                <form method="GET" action="{{ route('admin.visa-applications') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                            <input type="text" id="search" name="search" value="{{ request('search') }}" 
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                   placeholder="Search by name, email, country...">
                        </div>
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select id="status" name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="">All Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>
                        <div>
                            <label for="destination_country" class="block text-sm font-medium text-gray-700">Country</label>
                            <input type="text" id="destination_country" name="destination_country" value="{{ request('destination_country') }}" 
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                   placeholder="Filter by destination country...">
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
                            <div>Applicant</div>
                            <div>Destination</div>
                            <div>Applied Date</div>
                            <div>Documents</div>
                            <div>Amount</div>
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
                                    <div class="text-sm text-gray-900">{{ $application->destination_country ?? 'Not specified' }}</div>
                                    <div class="text-sm text-gray-500">{{ $application->created_at->format('M d, Y') }}</div>
                                    <div class="text-sm text-gray-500">
                                        @if($application->documents)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $application->documents->count() }} files
                                            </span>
                                        @else
                                            <span class="text-gray-400">No documents</span>
                                        @endif
                                    </div>
                                    <div class="text-sm text-gray-900">
                                        @if($application->payments && $application->payments->sum('amount') > 0)
                                            ${{ number_format($application->payments->sum('amount'), 2) }}
                                        @else
                                            <span class="text-gray-400">-</span>
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
                                        <a href="{{ route('admin.visa-applications.show', $application) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                                            View
                                        </a>
                                        <form method="POST" action="{{ route('admin.visa-applications.status', $application) }}" class="inline">
                                            @csrf
                                            <select name="status" onchange="this.form.submit()" class="text-sm border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                                <option value="pending" {{ $application->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="processing" {{ $application->status === 'processing' ? 'selected' : '' }}>Processing</option>
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.707.293H19a2 2 0 012 2v1a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.707.293H19a2 2 0 012 2v1a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.707.293H19a2 2 0 012 2v1a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.707.293H19a2 2 0 012 2v1a2 2 0 01-2 2H7z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No visa applications found</h3>
                    <p class="mt-1 text-sm text-gray-500">Try adjusting your search or filter criteria.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection