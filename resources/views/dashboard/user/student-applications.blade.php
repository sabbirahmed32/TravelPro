@extends('layouts.dashboard')

@section('title', 'Student Applications')

@section('header', 'Student Applications')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-2xl font-semibold text-gray-900">Student Applications</h1>
            <p class="mt-1 text-sm text-gray-500">Manage your student admission applications and track their progress</p>
        </div>

        <!-- Applications List -->
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            @if($applications->count() > 0)
                <ul class="divide-y divide-gray-200">
                    @foreach($applications as $application)
                        <li>
                            <div class="px-4 py-4 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                                                <i class="fas fa-graduation-cap text-green-600"></i>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $application->university_name ?? 'Unknown University' }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $application->course_name ?? 'Unknown Course' }} • Applied on {{ $application->created_at->format('M d, Y') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $application->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                               ($application->status === 'rejected' ? 'bg-red-100 text-red-800' : 
                                               'bg-yellow-100 text-yellow-800') }}">
                                            {{ ucfirst($application->status) }}
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No student applications</h3>
                    <p class="mt-1 text-sm text-gray-500">Get started by creating a new student application.</p>
                    <div class="mt-6">
                        <a href="{{ route('student-admission') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <i class="fas fa-plus -ml-1 mr-2"></i>
                            New Student Application
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection