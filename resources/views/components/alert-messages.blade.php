@if (session()->has('success'))
<div class="mb-4 bg-green-50 border-l-4 border-green-400 p-4">
    <div class="flex">
        <div class="flex-shrink-0">
            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 00016zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 7.707a1 1 0 01-1.414 0l3 3a1 1 0 001.414 1.414l-3-3a1 1 0 00-1.414 0z" clip-rule="evenodd" />
            </svg>
        </div>
        <div class="ml-3">
            <p class="text-sm font-medium text-green-800">
                {{ session()->get('success') }}
            </p>
        </div>
    </div>
</div>
@endif

@if (session()->has('error'))
<div class="mb-4 bg-red-50 border-l-4 border-red-400 p-4">
    <div class="flex">
        <div class="flex-shrink-0">
            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 00016zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-2.293 2.293a1 1 0 101.414 1.414L10 11.414l2.293 2.293a1 1 0 001.414-1.414L11.414 10l2.293-2.293a1 1 0 00-1.414-1.414L10 8.586 8.707a1 1 0 00-1.414 0z" clip-rule="evenodd" />
            </svg>
        </div>
        <div class="ml-3">
            <p class="text-sm font-medium text-red-800">
                {{ session()->get('error') }}
            </p>
        </div>
    </div>
</div>
@endif

@if (session()->has('warning'))
<div class="mb-4 bg-yellow-50 border-l-4 border-yellow-400 p-4">
    <div class="flex">
        <div class="flex-shrink-0">
            <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 4.565 0l1.1-3.547h1.1l1.1 3.547c0 1.843-1.595 4.565-4.565 4.565zm1.929 3.657l-16 4.676a1 1 0 00-1.886.018L7.662 19.434c-.331.12-.578.276-.72.576l4.965-4.772c.184-.09.404-.09-.61.09h.004a1 1 0 00-.404.018L2.15 13.525c-.233.097-.528.097-.816.097-.289 0-.596-.15-.796l4.62-4.649a1 1 0 00-.675-.718l-4.622 4.647a1 1 0 01-.678.679L2.15 16.53a1 1 0 00.675-.718l4.62-4.647c.098-.197.098-.437.098-.653v-.004a1 1 0 00-.596-.596l-4.62 4.647z" clip-rule="evenodd" />
            </svg>
        </div>
        <div class="ml-3">
            <p class="text-sm font-medium text-yellow-800">
                {{ session()->get('warning') }}
            </p>
        </div>
    </div>
</div>
@endif

<!-- Success/Error Messages for AJAX -->
<div id="alert-container" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex min-h-screen items-end justify-center px-4 pt-4 pb-20 text-center sm:p-0">
        <div class="bg-white rounded-lg shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div id="alert-content"></div>
        </div>
    </div>
</div>

<script>
function showAlert(type, message) {
    const alertContainer = document.getElementById('alert-container');
    const alertContent = document.getElementById('alert-content');
    
    let alertHtml = '';
    
    if (type === 'success') {
        alertHtml = `
            <div class="bg-green-50 border-l-4 border-green-400 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 00016zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 7.707a1 1 0 01-1.414 0l3 3a1 1 0 001.414 1.414l-3-3a1 1 0 00-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">${message}</p>
                    </div>
                </div>
            </div>
        `;
    } else if (type === 'error') {
        alertHtml = `
            <div class="bg-red-50 border-l-4 border-red-400 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 00016zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-2.293 2.293a1 1 0 101.414 1.414L10 11.414l2.293 2.293a1 1 0 001.414-1.414L11.414 10l2.293-2.293a1 1 0 00-1.414-1.414L10 8.586 8.707a1 1 0 00-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-red-800">${message}</p>
                    </div>
                </div>
            </div>
        `;
    }
    
    alertContent.innerHTML = alertHtml;
    alertContainer.classList.remove('hidden');
    
    setTimeout(() => {
        alertContainer.classList.add('hidden');
    }, 3000);
}

// Handle AJAX success/error responses
function handleAjaxResponse(response) {
    if (response.success) {
        showAlert('success', response.message);
        // Optionally redirect after delay
        setTimeout(() => {
            window.location.href = '/admin/users';
        }, 2000);
    } else {
        showAlert('error', response.message);
    }
}
</script>