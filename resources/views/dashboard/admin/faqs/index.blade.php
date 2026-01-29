@extends('layouts.dashboard')

@section('title', 'Manage FAQs')

@section('header', 'FAQ Management')

@section('content')
<!-- Include Alert Messages -->
@include('components.alert-messages')

<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">FAQs</h1>
                <p class="mt-1 text-sm text-gray-500">Manage frequently asked questions</p>
            </div>
            <div class="flex space-x-3">
                <button onclick="openCreateModal()" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <i class="fas fa-plus -ml-1 mr-2"></i>
                    New FAQ
                </button>
                <button onclick="window.location.reload()" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <i class="fas fa-sync -ml-1 mr-2"></i>
                    Refresh
                </button>
            </div>
        </div>

        <!-- Search and Filters -->
        <div class="bg-white shadow rounded-lg mb-6">
            <div class="px-4 py-5 sm:p-6">
                <form method="GET" action="{{ route('admin.faqs') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                            <input type="text" id="search" name="search" value="{{ request('search') }}" 
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                   placeholder="Search by question, answer...">
                        </div>
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                            <select id="category" name="category" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="">All Categories</option>
                                <option value="visa" {{ request('category') == 'visa' ? 'selected' : '' }}>Visa Services</option>
                                <option value="admission" {{ request('category') == 'admission' ? 'selected' : '' }}>Student Admission</option>
                                <option value="travel" {{ request('category') == 'travel' ? 'selected' : '' }}>Travel & Tours</option>
                                <option value="consultation" {{ request('category') == 'consultation' ? 'selected' : '' }}>Consultation</option>
                                <option value="general" {{ request('category') == 'general' ? 'selected' : '' }}>General</option>
                            </select>
                        </div>
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select id="status" name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="">All Status</option>
                                <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <i class="fas fa-search mr-2"></i>
                            Search
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- FAQs Table -->
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            @if($faqs->count() > 0)
                <ul class="divide-y divide-gray-200">
                    @foreach($faqs as $faq)
                        <li class="hover:bg-gray-50">
                            <div class="px-4 py-4 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between">
                                            <p class="text-sm font-medium text-indigo-600 truncate">
                                                {{ Str::limit($faq->question, 80) }}
                                            </p>
                                            <div class="ml-2 flex-shrink-0 flex space-x-2">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                     {{ $faq->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                     {{ $faq->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    {{ $faq->category_label }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            <p class="text-sm text-gray-600">
                                                {{ Str::limit(strip_tags($faq->answer), 150) }}
                                            </p>
                                            <div class="mt-2 flex items-center text-sm text-gray-500">
                                                <i class="fas fa-sort-amount-down mr-1"></i>
                                                Sort Order: {{ $faq->sort_order }}
                                                <span class="mx-2">•</span>
                                                <i class="fas fa-clock mr-1"></i>
                                                Created: {{ $faq->created_at->format('M d, Y H:i') }}
                                                <span class="mx-2">•</span>
                                                <i class="fas fa-edit mr-1"></i>
                                                Updated: {{ $faq->updated_at->format('M d, Y H:i') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0 ml-4">
                                        <div class="flex space-x-2">
                                            <button onclick="editFaq({{ $faq->id }}, '{{ $faq->question }}', '{{ $faq->answer }}', '{{ $faq->category }}', {{ $faq->sort_order }}, {{ $faq->is_active }})" class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                                Edit
                                            </button>
                                            <form method="POST" action="{{ route('admin.faqs.toggle', $faq) }}" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-yellow-600 hover:text-yellow-900 text-sm font-medium">
                                                    {{ $faq->is_active ? 'Deactivate' : 'Activate' }}
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.faqs.destroy', $faq) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this FAQ?')">
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
                    <i class="fas fa-question-circle text-gray-400 text-5xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No FAQs found</h3>
                    <p class="text-gray-500">No FAQs match your current filters.</p>
                    <div class="mt-6">
                        <button onclick="openCreateModal()" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <i class="fas fa-plus -ml-1 mr-2"></i>
                            Create First FAQ
                        </button>
                    </div>
                </div>
            @endif
        </div>

        <!-- Pagination -->
        @if($faqs->hasPages())
            <div class="mt-6">
                {{ $faqs->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Create/Edit FAQ Modal -->
<div id="faqModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden" style="z-index: 9999;">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" id="modalTitle">Create New FAQ</h3>
            <form id="faqForm" method="POST" action="{{ route('admin.faqs.store') }}">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="question" class="block text-sm font-medium text-gray-700">Question</label>
                        <textarea id="question" name="question" rows="2" required
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                  placeholder="Enter the FAQ question..."></textarea>
                    </div>
                    <div>
                        <label for="answer" class="block text-sm font-medium text-gray-700">Answer</label>
                        <textarea id="answer" name="answer" rows="4" required
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                  placeholder="Enter the FAQ answer..."></textarea>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                            <select id="category" name="category" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="">Select Category</option>
                                <option value="visa">Visa Services</option>
                                <option value="admission">Student Admission</option>
                                <option value="travel">Travel & Tours</option>
                                <option value="consultation">Consultation</option>
                                <option value="general">General</option>
                            </select>
                        </div>
                        <div>
                            <label for="sort_order" class="block text-sm font-medium text-gray-700">Sort Order</label>
                            <input type="number" id="sort_order" name="sort_order" value="0" min="0"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                        <div>
                            <label class="flex items-center mt-6">
                                <input type="checkbox" id="is_active" name="is_active" value="1" checked
                                       class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                <span class="ml-2 text-sm text-gray-700">Active</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="closeModal()" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Cancel
                    </button>
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Save FAQ
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let currentEditId = null;

function openCreateModal() {
    currentEditId = null;
    document.getElementById('modalTitle').textContent = 'Create New FAQ';
    document.getElementById('faqForm').reset();
    document.getElementById('faqForm').action = '{{ route('admin.faqs.store') }}';
    document.getElementById('faqModal').classList.remove('hidden');
}

function editFaq(id, question, answer, category, sortOrder, isActive) {
    currentEditId = id;
    document.getElementById('modalTitle').textContent = 'Edit FAQ';
    document.getElementById('question').value = question;
    document.getElementById('answer').value = answer;
    document.getElementById('category').value = category;
    document.getElementById('sort_order').value = sortOrder;
    document.getElementById('is_active').checked = isActive;
    
    // Update form action for edit
    const form = document.getElementById('faqForm');
    form.action = `/admin/faqs/${id}`;
    form.method = 'POST';
    
    // Add PUT method override for edit
    let methodInput = form.querySelector('input[name="_method"]');
    if (!methodInput) {
        methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        form.appendChild(methodInput);
    }
    methodInput.value = 'PUT';
    
    document.getElementById('faqModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('faqModal').classList.add('hidden');
    document.getElementById('faqForm').reset();
    
    // Remove method override if it exists
    const methodInput = document.querySelector('input[name="_method"]');
    if (methodInput) {
        methodInput.remove();
    }
    
    // Reset form action
    document.getElementById('faqForm').action = '{{ route('admin.faqs.store') }}';
    document.getElementById('faqForm').method = 'POST';
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('faqModal');
    if (event.target == modal) {
        closeModal();
    }
}
</script>
@endsection