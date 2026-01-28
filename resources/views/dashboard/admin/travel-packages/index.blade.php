@extends('layouts.dashboard')

@section('title', 'Manage Travel Packages')

@section('header', 'Travel Package Management')

@section('content')
<!-- Include Alert Messages -->
@include('components.alert-messages')

<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Travel Packages</h1>
                <p class="mt-1 text-sm text-gray-500">Manage all travel packages and tour offerings</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.travel-packages.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <i class="fas fa-plus -ml-1 mr-2"></i>
                    Add Package
                </a>
                <button onclick="window.location.reload()" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <i class="fas fa-sync -ml-1 mr-2"></i>
                    Refresh
                </button>
            </div>
        </div>

        <!-- Search and Filters -->
        <div class="bg-white shadow rounded-lg mb-6">
            <div class="px-4 py-5 sm:p-6">
                <form method="GET" action="{{ route('admin.travel-packages') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                            <input type="text" id="search" name="search" value="{{ request('search') }}" 
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                   placeholder="Search by name, destination...">
                        </div>
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select id="status" name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="">All Status</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="featured" {{ request('status') == 'featured' ? 'selected' : '' }}>Featured</option>
                            </select>
                        </div>
                        <div>
                            <label for="destination" class="block text-sm font-medium text-gray-700">Destination</label>
                            <select id="destination" name="destination" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="">All Destinations</option>
                                <option value="dubai" {{ request('destination') == 'dubai' ? 'selected' : '' }}>Dubai</option>
                                <option value="singapore" {{ request('destination') == 'singapore' ? 'selected' : '' }}>Singapore</option>
                                <option value="malaysia" {{ request('destination') == 'malaysia' ? 'selected' : '' }}>Malaysia</option>
                                <option value="thailand" {{ request('destination') == 'thailand' ? 'selected' : '' }}>Thailand</option>
                                <option value="europe" {{ request('destination') == 'europe' ? 'selected' : '' }}>Europe</option>
                                <option value="usa" {{ request('destination') == 'usa' ? 'selected' : '' }}>USA</option>
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

        <!-- Travel Packages Table -->
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            @if($packages->count() > 0)
                <ul class="divide-y divide-gray-200">
                    @foreach($packages as $package)
                        <li class="hover:bg-gray-50">
                            <div class="px-4 py-4 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between">
                                            <p class="text-sm font-medium text-indigo-600 truncate">
                                                {{ $package->name }}
                                            </p>
                                            <div class="ml-2 flex-shrink-0 flex space-x-2">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                     {{ $package->status === 'active' ? 'bg-green-100 text-green-800' : 
                                                        ($package->status === 'featured' ? 'bg-purple-100 text-purple-800' : 
                                                        'bg-gray-100 text-gray-800') }}">
                                                     {{ ucfirst($package->status ?? 'inactive') }}
                                                </span>
                                                @if($package->featured)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                        <i class="fas fa-star mr-1"></i>Featured
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            <p class="text-sm text-gray-500">
                                                <i class="fas fa-map-marker-alt mr-1"></i> {{ ucfirst($package->destination ?? 'Unknown') }}
                                                <span class="mx-2">•</span>
                                                <i class="fas fa-clock mr-1"></i> {{ $package->duration ?? 'N/A' }} days
                                                <span class="mx-2">•</span>
                                                <i class="fas fa-tag mr-1"></i> {{ $package->price ?? '0' }} {{ $package->currency ?? 'USD' }}
                                            </p>
                                            @if($package->description)
                                                <p class="text-sm text-gray-600 mt-2 line-clamp-2">{{ Str::limit(strip_tags($package->description), 150) }}</p>
                                            @endif
                                            <div class="mt-2 flex items-center text-sm text-gray-500">
                                                <i class="fas fa-calendar mr-1"></i>
                                                Created: {{ $package->created_at->format('M d, Y') }}
                                                @if($package->start_date && $package->end_date)
                                                    <span class="mx-2">•</span>
                                                    <i class="fas fa-plane mr-1"></i>
                                                    {{ \Carbon\Carbon::parse($package->start_date)->format('M d') }} - {{ \Carbon\Carbon::parse($package->end_date)->format('M d, Y') }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0 ml-4">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('admin.travel-packages.show', $package) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                                                View
                                            </a>
                                            <a href="{{ route('admin.travel-packages.edit', $package) }}" class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                                Edit
                                            </a>
                                            @if($package->status === 'active')
                                                <form method="POST" action="{{ route('admin.travel-packages.deactivate', $package) }}" class="inline" onsubmit="return confirm('Are you sure you want to deactivate this package?')">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="text-yellow-600 hover:text-yellow-900 text-sm font-medium">
                                                        Deactivate
                                                    </button>
                                                </form>
                                            @else
                                                <form method="POST" action="{{ route('admin.travel-packages.activate', $package) }}" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="text-green-600 hover:text-green-900 text-sm font-medium">
                                                        Activate
                                                    </button>
                                                </form>
                                            @endif
                                            <form method="POST" action="{{ route('admin.travel-packages.destroy', $package) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this package?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-medium">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-suitcase text-gray-400 text-5xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No travel packages found</h3>
                    <p class="text-gray-500">No travel packages match your current filters.</p>
                    <div class="mt-6">
                        <a href="{{ route('admin.travel-packages.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <i class="fas fa-plus -ml-1 mr-2"></i>
                            Create First Package
                        </a>
                    </div>
                </div>
            @endif
        </div>

        <!-- Pagination -->
        @if($packages->hasPages())
            <div class="mt-6">
                {{ $packages->links() }}
            </div>
        @endif
    </div>
</div>
@endsection