@extends('layouts.dashboard')

@section('title', 'Manage Consultations')

@section('header', 'Consultation Management')

@section('content')
<!-- Include Alert Messages -->
@include('components.alert-messages')

<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Consultations</h1>
                <p class="mt-1 text-sm text-gray-500">Manage all consultation requests and appointments</p>
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
                <form method="GET" action="{{ route('admin.consultations') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                            <input type="text" id="search" name="search" value="{{ request('search') }}" 
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                   placeholder="Search by name, email...">
                        </div>
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select id="status" name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="">All Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <div>
                            <label for="consultation_type" class="block text-sm font-medium text-gray-700">Consultation Type</label>
                            <select id="consultation_type" name="consultation_type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="">All Types</option>
                                <option value="visa" {{ request('consultation_type') == 'visa' ? 'selected' : '' }}>Visa</option>
                                <option value="education" {{ request('consultation_type') == 'education' ? 'selected' : '' }}>Education</option>
                                <option value="travel" {{ request('consultation_type') == 'travel' ? 'selected' : '' }}>Travel</option>
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <i class="fas fa-search mr-2"></i>
                                Search
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Consultations Table -->
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            @if($consultations->count() > 0)
                <ul class="divide-y divide-gray-200">
                    @foreach($consultations as $consultation)
                        <li class="hover:bg-gray-50">
                            <div class="px-4 py-4 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between">
                                            <p class="text-sm font-medium text-indigo-600 truncate">
                                                {{ $consultation->name }}
                                            </p>
                                            <div class="ml-2 flex-shrink-0 flex">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                     {{ $consultation->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                                        ($consultation->status === 'scheduled' ? 'bg-blue-100 text-blue-800' : 
                                                        ($consultation->status === 'cancelled' ? 'bg-red-100 text-red-800' : 
                                                        'bg-yellow-100 text-yellow-800')) }}">
                                                     {{ ucfirst($consultation->status ?? 'pending') }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            <p class="text-sm text-gray-500">
                                                <i class="fas fa-envelope mr-1"></i> {{ $consultation->email }}
                                                @if($consultation->phone)
                                                    <span class="mx-2">•</span>
                                                    <i class="fas fa-phone mr-1"></i> {{ $consultation->phone }}
                                                @endif
                                            </p>
                                            <p class="text-sm text-gray-500 mt-1">
                                                <i class="fas fa-tag mr-1"></i> {{ ucfirst($consultation->consultation_type ?? 'general') }}
                                                @if($consultation->preferred_date)
                                                    <span class="mx-2">•</span>
                                                    <i class="fas fa-calendar mr-1"></i> {{ \Carbon\Carbon::parse($consultation->preferred_date)->format('M d, Y') }}
                                                @endif
                                            </p>
                                            @if($consultation->message)
                                                <p class="text-sm text-gray-600 mt-2 line-clamp-2">{{ Str::limit($consultation->message, 100) }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0 ml-4">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('admin.consultations.show', $consultation) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                                                View
                                            </a>
                                            @if($consultation->status === 'pending')
                                                <form method="POST" action="{{ route('admin.consultations.schedule', $consultation) }}" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="text-green-600 hover:text-green-900 text-sm font-medium">
                                                        Schedule
                                                    </button>
                                                </form>
                                            @endif
                                            @if($consultation->status === 'scheduled')
                                                <form method="POST" action="{{ route('admin.consultations.complete', $consultation) }}" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                                        Complete
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-comments text-gray-400 text-5xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No consultations found</h3>
                    <p class="text-gray-500">No consultation requests match your current filters.</p>
                </div>
            @endif
        </div>

        <!-- Pagination -->
        @if($consultations->hasPages())
            <div class="mt-6">
                {{ $consultations->links() }}
            </div>
        @endif
    </div>
</div>
@endsection