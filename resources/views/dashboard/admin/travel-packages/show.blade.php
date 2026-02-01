@extends('layouts.dashboard')

@section('title', 'Travel Package Details')

@section('header', 'Travel Package Details')

@section('content')
<!-- Include Alert Messages -->
@include('components.alert-messages')

<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900">{{ $travelPackage->title }}</h1>
                    <p class="mt-1 text-sm text-gray-500">Package ID: {{ $travelPackage->id }}</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.travel-packages.edit', $travelPackage) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <i class="fas fa-edit -ml-1 mr-2"></i>
                        Edit Package
                    </a>
                    <a href="{{ route('admin.travel-packages') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <i class="fas fa-arrow-left -ml-1 mr-2"></i>
                        Back to Packages
                    </a>
                </div>
            </div>
        </div>

        <!-- Package Details -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Package Information</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Complete details of the travel package.</p>
            </div>
            <div class="border-t border-gray-200">
                <dl>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Package Name</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $travelPackage->title }}</dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Destination</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ ucfirst($travelPackage->destination) }}</dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Description</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $travelPackage->description }}</dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Price</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">${{ number_format($travelPackage->price, 2) }}</dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Duration</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $travelPackage->duration_days }} days</dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Travel Dates</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            @if($travelPackage->start_date && $travelPackage->end_date)
                                {{ \Carbon\Carbon::parse($travelPackage->start_date)->format('M d, Y') }} - {{ \Carbon\Carbon::parse($travelPackage->end_date)->format('M d, Y') }}
                            @else
                                Not specified
                            @endif
                        </dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Maximum Travelers</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $travelPackage->max_travelers }}</dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            @if($travelPackage->is_active)
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                            @else
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Inactive</span>
                            @endif
                        </dd>
                    </div>
                    @if($travelPackage->image)
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Package Image</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            <img src="{{ asset('storage/' . $travelPackage->image) }}" alt="{{ $travelPackage->title }}" class="h-32 w-48 object-cover rounded-lg shadow-md">
                        </dd>
                    </div>
                    @endif
                </dl>
            </div>
        </div>

        <!-- Actions -->
        <div class="mt-6 flex justify-end space-x-3">
            @if($travelPackage->is_active)
            <form action="{{ route('admin.travel-packages.deactivate', $travelPackage) }}" method="POST" class="inline">
                @csrf
                @method('PATCH')
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <i class="fas fa-power-off -ml-1 mr-2"></i>
                    Deactivate
                </button>
            </form>
            @else
            <form action="{{ route('admin.travel-packages.activate', $travelPackage) }}" method="POST" class="inline">
                @csrf
                @method('PATCH')
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <i class="fas fa-power-off -ml-1 mr-2"></i>
                    Activate
                </button>
            </form>
            @endif
            <form action="{{ route('admin.travel-packages.destroy', $travelPackage) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this package?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    <i class="fas fa-trash -ml-1 mr-2"></i>
                    Delete Package
                </button>
            </form>
        </div>
    </div>
</div>
@endsection