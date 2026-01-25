@extends('layouts.dashboard')

@section('title', 'Payments')

@section('header', 'Payments')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-2xl font-semibold text-gray-900">Payment History</h1>
            <p class="mt-1 text-sm text-gray-500">View your payment transactions and receipts</p>
        </div>

        <!-- Payments List -->
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            @if($payments->count() > 0)
                <ul class="divide-y divide-gray-200">
                    @foreach($payments as $payment)
                        <li>
                            <div class="px-4 py-4 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                                <i class="fas fa-credit-card text-indigo-600"></i>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $payment->transaction_id ?? 'Transaction' }} #{{ $payment->id }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $payment->payment_method ?? 'Unknown Method' }} • 
                                                {{ $payment->created_at->format('M d, Y g:i A') }}
                                            </div>
                                            @if($payment->description)
                                                <div class="text-sm text-gray-500">
                                                    {{ $payment->description }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <div class="text-right">
                                            <div class="text-sm font-medium text-gray-900">
                                                ${{ number_format($payment->amount, 2) }}
                                            </div>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                {{ $payment->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                                   ($payment->status === 'failed' ? 'bg-red-100 text-red-800' : 
                                                   ($payment->status === 'refunded' ? 'bg-gray-100 text-gray-800' :
                                                   'bg-yellow-100 text-yellow-800')) }}">
                                                {{ ucfirst($payment->status ?? 'pending') }}
                                            </span>
                                        </div>
                                        <a href="#" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                                            View Receipt
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
                        @if($payments->hasPages())
                            <a href="{{ $payments->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Previous
                            </a>
                            <a href="{{ $payments->nextPageUrl() }}" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Next
                            </a>
                        @endif
                    </div>
                    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm text-gray-700">
                                Showing
                                <span class="font-medium">{{ $payments->firstItem() }}</span>
                                to
                                <span class="font-medium">{{ $payments->lastItem() }}</span>
                                of
                                <span class="font-medium">{{ $payments->total() }}</span>
                                results
                            </p>
                        </div>
                        <div>
                            {{ $payments->links() }}
                        </div>
                    </div>
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No payments</h3>
                    <p class="mt-1 text-sm text-gray-500">You haven't made any payments yet.</p>
                    <div class="mt-6">
                        <a href="{{ route('visa-services') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <i class="fas fa-compass -ml-1 mr-2"></i>
                            Explore Services
                        </a>
                    </div>
                </div>
            @endif
        </div>

        <!-- Summary Card -->
        @if($payments->count() > 0)
        <div class="mt-6 bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Payment Summary</h3>
                <div class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-3">
                    <div class="bg-green-50 px-4 py-5 rounded-lg">
                        <dt class="text-sm font-medium text-green-800 truncate">Completed</dt>
                        <dd class="mt-1 text-3xl font-semibold text-green-900">
                            ${{ number_format($payments->where('status', 'completed')->sum('amount'), 2) }}
                        </dd>
                    </div>
                    <div class="bg-yellow-50 px-4 py-5 rounded-lg">
                        <dt class="text-sm font-medium text-yellow-800 truncate">Pending</dt>
                        <dd class="mt-1 text-3xl font-semibold text-yellow-900">
                            ${{ number_format($payments->where('status', 'pending')->sum('amount'), 2) }}
                        </dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 rounded-lg">
                        <dt class="text-sm font-medium text-gray-800 truncate">Total</dt>
                        <dd class="mt-1 text-3xl font-semibold text-gray-900">
                            ${{ number_format($payments->sum('amount'), 2) }}
                        </dd>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection