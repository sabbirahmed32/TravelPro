<!-- User Dashboard -->
<div x-data="userDashboardData()">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Visa Applications Card -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                        <i class="fas fa-passport text-white"></i>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Visa Applications</dt>
                        <dd class="text-lg font-semibold text-gray-900" x-text="stats.visa_applications_count"></dd>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Student Applications Card -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                        <i class="fas fa-graduation-cap text-white"></i>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Student Applications</dt>
                        <dd class="text-lg font-semibold text-gray-900" x-text="stats.student_applications_count"></dd>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Active Bookings Card -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                        <i class="fas fa-calendar-check text-white"></i>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Active Bookings</dt>
                        <dd class="text-lg font-semibold text-gray-900" x-text="stats.active_bookings"></dd>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Total Spent Card -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-purple-500 rounded-md flex items-center justify-center">
                        <i class="fas fa-dollar-sign text-white"></i>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Spent</dt>
                        <dd class="text-lg font-semibold text-gray-900" x-text="'$' + stats.total_spent"></dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- My Activities -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- My Visa Applications -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900">My Visa Applications</h3>
                <a href="{{ route('visa-applications.index') }}" class="text-sm text-indigo-600 hover:text-indigo-900">View All</a>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <template x-for="application in visa_applications" :key="application.id">
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="text-sm font-medium text-gray-900" x-text="application.destination_country + ' - ' + application.visa_type"></h4>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                    :class="getStatusColor(application.status)"
                                    x-text="application.status"></span>
                            </div>
                            <p class="text-xs text-gray-500 mb-2">
                                Applied: <span x-text="new Date(application.created_at).toLocaleDateString()"></span>
                            </p>
                            <div class="flex items-center space-x-2">
                                <template x-for="document in application.documents" :key="document.id">
                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs bg-gray-100 text-gray-700">
                                        <i class="fas fa-file-pdf text-red-500 mr-1"></i>
                                        <span x-text="document.name"></span>
                                    </span>
                                </template>
                            </div>
                        </div>
                    </template>
                    
                    <div x-show="visa_applications.length === 0" class="text-center py-8 text-gray-500">
                        <i class="fas fa-passport text-4xl mb-4"></i>
                        <p>No visa applications yet</p>
                        <a href="{{ route('visa-applications.create') }}" class="mt-2 inline-flex items-center text-sm text-indigo-600 hover:text-indigo-900">
                            <i class="fas fa-plus mr-1"></i>
                            Apply Now
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- My Student Applications -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900">My Student Applications</h3>
                <a href="{{ route('student-applications.index') }}" class="text-sm text-indigo-600 hover:text-indigo-900">View All</a>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <template x-for="application in student_applications" :key="application.id">
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="text-sm font-medium text-gray-900" x-text="application.desired_course"></h4>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                    :class="getStatusColor(application.status)"
                                    x-text="application.status"></span>
                            </div>
                            <p class="text-xs text-gray-500 mb-2" x-text="application.desired_university + ' - ' + application.target_country"></p>
                            <p class="text-xs text-gray-500">GPA: <span x-text="application.gpa"></span></p>
                        </div>
                    </template>
                    
                    <div x-show="student_applications.length === 0" class="text-center py-8 text-gray-500">
                        <i class="fas fa-graduation-cap text-4xl mb-4"></i>
                        <p>No student applications yet</p>
                        <a href="{{ route('student-applications.create') }}" class="mt-2 inline-flex items-center text-sm text-indigo-600 hover:text-indigo-900">
                            <i class="fas fa-plus mr-1"></i>
                            Apply Now
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- My Bookings -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900">My Bookings</h3>
                <a href="{{ route('bookings.index') }}" class="text-sm text-indigo-600 hover:text-indigo-900">View All</a>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <template x-for="booking in bookings" :key="booking.id">
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="text-sm font-medium text-gray-900" x-text="booking.travel_package.title"></h4>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                    :class="getStatusColor(booking.status)"
                                    x-text="booking.status"></span>
                            </div>
                            <p class="text-xs text-gray-500 mb-2">
                                Ref: <span x-text="booking.booking_reference"></span> | 
                                Travelers: <span x-text="booking.number_of_travelers"></span>
                            </p>
                            <p class="text-sm font-medium text-gray-900" x-text="'$' + booking.total_price"></p>
                        </div>
                    </template>
                    
                    <div x-show="bookings.length === 0" class="text-center py-8 text-gray-500">
                        <i class="fas fa-calendar-check text-4xl mb-4"></i>
                        <p>No bookings yet</p>
                        <a href="{{ route('packages.index') }}" class="mt-2 inline-flex items-center text-sm text-indigo-600 hover:text-indigo-900">
                            <i class="fas fa-search mr-1"></i>
                            Browse Packages
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- My Consultations -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900">My Consultations</h3>
                <a href="{{ route('consultations.index') }}" class="text-sm text-indigo-600 hover:text-indigo-900">View All</a>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <template x-for="consultation in consultations" :key="consultation.id">
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="text-sm font-medium text-gray-900" x-text="consultation.consultation_type"></h4>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                    :class="getStatusColor(consultation.status)"
                                    x-text="consultation.status"></span>
                            </div>
                            <p class="text-xs text-gray-500 mb-2">
                                Preferred: <span x-text="new Date(consultation.preferred_date_time).toLocaleDateString()"></span>
                            </p>
                            <p class="text-sm text-gray-600" x-text="consultation.message?.substring(0, 100) + '...'"></p>
                        </div>
                    </template>
                    
                    <div x-show="consultations.length === 0" class="text-center py-8 text-gray-500">
                        <i class="fas fa-comments text-4xl mb-4"></i>
                        <p>No consultations yet</p>
                        <a href="{{ route('consultations.create') }}" class="mt-2 inline-flex items-center text-sm text-indigo-600 hover:text-indigo-900">
                            <i class="fas fa-plus mr-1"></i>
                            Book Consultation
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function userDashboardData() {
    return {
        stats: {},
        visa_applications: [],
        student_applications: [],
        bookings: [],
        consultations: [],
        
        async init() {
            await this.loadData();
        },
        
        async loadData() {
            try {
                const response = await fetch('/api/dashboard', {
                    headers: {
                        'Authorization': 'Bearer ' + document.querySelector('meta[name="api-token"]')?.content
                    }
                });
                const data = await response.json();
                
                this.stats = data.stats;
                this.visa_applications = data.visa_applications;
                this.student_applications = data.student_applications;
                this.bookings = data.bookings;
                this.consultations = data.consultations;
            } catch (error) {
                console.error('Error loading dashboard data:', error);
            }
        },
        
        getStatusColor(status) {
            const colors = {
                'pending': 'bg-yellow-100 text-yellow-800',
                'under_review': 'bg-blue-100 text-blue-800',
                'approved': 'bg-green-100 text-green-800',
                'completed': 'bg-purple-100 text-purple-800',
                'rejected': 'bg-red-100 text-red-800',
                'confirmed': 'bg-blue-100 text-blue-800',
                'paid': 'bg-green-100 text-green-800',
                'scheduled': 'bg-indigo-100 text-indigo-800'
            };
            return colors[status] || 'bg-gray-100 text-gray-800';
        }
    }
}
</script>