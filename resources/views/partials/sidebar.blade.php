<div class="flex flex-col h-full bg-indigo-900">
    <div class="flex items-center h-16 px-4 bg-indigo-900">
        <i class="fas fa-plane text-white text-2xl"></i>
        <span class="ml-2 text-white text-lg font-semibold">TravelBiz</span>
    </div>
    
    <div class="flex-1 flex flex-col overflow-y-auto">
        <nav class="flex-1 px-2 py-4 space-y-1">
            @if(auth()->user()->isAdmin())
                <!-- Admin Menu -->
                <a href="{{ route('admin.index') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.index') ? 'bg-indigo-800 text-white' : 'text-indigo-100 hover:bg-indigo-700' }}">
                    <i class="fas fa-tachometer-alt mr-3"></i>
                    Dashboard
                </a>
                
                <div class="mt-6">
                    <h3 class="px-2 text-xs font-semibold text-indigo-200 uppercase tracking-wider">Management</h3>
                </div>
                
                <a href="{{ route('admin.users') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.users*') ? 'bg-indigo-800 text-white' : 'text-indigo-100 hover:bg-indigo-700' }}">
                    <i class="fas fa-users mr-3"></i>
                    Users
                </a>
                
                <a href="{{ route('admin.visa-applications') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.visa-applications*') ? 'bg-indigo-800 text-white' : 'text-indigo-100 hover:bg-indigo-700' }}">
                    <i class="fas fa-passport mr-3"></i>
                    Visa Applications
                </a>
                
                <a href="{{ route('admin.student-applications') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.student-applications*') ? 'bg-indigo-800 text-white' : 'text-indigo-100 hover:bg-indigo-700' }}">
                    <i class="fas fa-graduation-cap mr-3"></i>
                    Student Applications
                </a>
                
                <a href="{{ route('admin.bookings') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.bookings*') ? 'bg-indigo-800 text-white' : 'text-indigo-100 hover:bg-indigo-700' }}">
                    <i class="fas fa-calendar-check mr-3"></i>
                    Bookings
                </a>
                
                <a href="{{ route('admin.consultations') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.consultations*') ? 'bg-indigo-800 text-white' : 'text-indigo-100 hover:bg-indigo-700' }}">
                    <i class="fas fa-comments mr-3"></i>
                    Consultations
                </a>
                
                <a href="{{ route('admin.travel-packages') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.travel-packages*') ? 'bg-indigo-800 text-white' : 'text-indigo-100 hover:bg-indigo-700' }}">
                    <i class="fas fa-suitcase mr-3"></i>
                    Travel Packages
                </a>
                
                <div class="mt-6">
                    <h3 class="px-2 text-xs font-semibold text-indigo-200 uppercase tracking-wider">Content</h3>
                </div>
                
                <a href="{{ route('admin.blogs') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.blogs*') ? 'bg-indigo-800 text-white' : 'text-indigo-100 hover:bg-indigo-700' }}">
                    <i class="fas fa-blog mr-3"></i>
                    Blog Posts
                </a>
                
                <a href="{{ route('admin.faqs') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.faqs*') ? 'bg-indigo-800 text-white' : 'text-indigo-100 hover:bg-indigo-700' }}">
                    <i class="fas fa-question-circle mr-3"></i>
                    FAQs
                </a>
                
                <a href="{{ route('admin.analytics') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.analytics*') ? 'bg-indigo-800 text-white' : 'text-indigo-100 hover:bg-indigo-700' }}">
                    <i class="fas fa-chart-line mr-3"></i>
                    Analytics
                </a>
                
            @else
                <!-- User Menu -->
                <a href="{{ route('dashboard.user') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('dashboard.user*') ? 'bg-indigo-800 text-white' : 'text-indigo-100 hover:bg-indigo-700' }}">
                    <i class="fas fa-tachometer-alt mr-3"></i>
                    Dashboard
                </a>
                
                <a href="{{ route('dashboard.profile') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('dashboard.profile*') ? 'bg-indigo-800 text-white' : 'text-indigo-100 hover:bg-indigo-700' }}">
                    <i class="fas fa-user mr-3"></i>
                    Profile
                </a>
                
                <a href="{{ route('dashboard.user.visa-applications') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('dashboard.user.visa-applications*') ? 'bg-indigo-800 text-white' : 'text-indigo-100 hover:bg-indigo-700' }}">
                    <i class="fas fa-passport mr-3"></i>
                    Visa Applications
                </a>
                
                <a href="{{ route('dashboard.user.student-applications') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('dashboard.user.student-applications*') ? 'bg-indigo-800 text-white' : 'text-indigo-100 hover:bg-indigo-700' }}">
                    <i class="fas fa-graduation-cap mr-3"></i>
                    Student Applications
                </a>
                
                <a href="{{ route('dashboard.user.bookings') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('dashboard.user.bookings*') ? 'bg-indigo-800 text-white' : 'text-indigo-100 hover:bg-indigo-700' }}">
                    <i class="fas fa-calendar-check mr-3"></i>
                    My Bookings
                </a>
                
                <a href="{{ route('dashboard.user.consultations') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('dashboard.user.consultations*') ? 'bg-indigo-800 text-white' : 'text-indigo-100 hover:bg-indigo-700' }}">
                    <i class="fas fa-comments mr-3"></i>
                    Consultations
                </a>
                
                <a href="{{ route('dashboard.user.payments') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('dashboard.user.payments*') ? 'bg-indigo-800 text-white' : 'text-indigo-100 hover:bg-indigo-700' }}">
                    <i class="fas fa-credit-card mr-3"></i>
                    Payments
                </a>
            @endif
        </nav>
    </div>
    
    <div class="flex-shrink-0 flex border-t border-indigo-800 p-4">
        <a href="{{ route('dashboard.profile') }}" class="flex-shrink-0 w-full group block">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="h-8 w-8 rounded-full bg-indigo-500 flex items-center justify-center">
                        <span class="text-white font-medium">{{ substr(auth()->user()->name, 0, 1) }}</span>
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-white">{{ auth()->user()->name }}</p>
                    <p class="text-xs font-medium text-indigo-200">{{ auth()->user()->role_label }}</p>
                </div>
            </div>
        </a>
    </div>
</div>