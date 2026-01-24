<!-- Admin Dashboard -->
<div x-data="dashboardData()">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Users Card -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                        <i class="fas fa-users text-white"></i>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Users</dt>
                        <dd class="text-lg font-semibold text-gray-900" x-text="stats.total_users"></dd>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Visa Applications Card -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                        <i class="fas fa-passport text-white"></i>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Pending Visa Apps</dt>
                        <dd class="text-lg font-semibold text-gray-900" x-text="stats.pending_visa_applications"></dd>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Bookings Card -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                        <i class="fas fa-calendar-check text-white"></i>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Pending Bookings</dt>
                        <dd class="text-lg font-semibold text-gray-900" x-text="stats.pending_bookings"></dd>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Revenue Card -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-purple-500 rounded-md flex items-center justify-center">
                        <i class="fas fa-dollar-sign text-white"></i>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Revenue</dt>
                        <dd class="text-lg font-semibold text-gray-900" x-text="'$' + stats.total_revenue"></dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Tables -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Revenue Chart -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Monthly Revenue</h3>
            <canvas id="revenueChart" width="400" height="200"></canvas>
        </div>

        <!-- Applications by Status -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Applications Status</h3>
            <canvas id="statusChart" width="400" height="200"></canvas>
        </div>
    </div>

    <!-- Recent Activity Tables -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Visa Applications -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Recent Visa Applications</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <template x-for="application in recent_applications" :key="application.id">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-900" x-text="application.first_name + ' ' + application.last_name"></p>
                                <p class="text-xs text-gray-500" x-text="application.destination_country"></p>
                            </div>
                            <div class="flex items-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                    :class="getStatusColor(application.status)"
                                    x-text="application.status"></span>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <!-- Recent Bookings -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Recent Bookings</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <template x-for="booking in recent_bookings" :key="booking.id">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-900" x-text="booking.user.name"></p>
                                <p class="text-xs text-gray-500" x-text="booking.booking_reference"></p>
                            </div>
                            <div class="flex items-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                    :class="getStatusColor(booking.status)"
                                    x-text="booking.status"></span>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <!-- Recent Consultations -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Recent Consultations</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <template x-for="consultation in recent_consultations" :key="consultation.id">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-900" x-text="consultation.user?.name || consultation.name"></p>
                                <p class="text-xs text-gray-500" x-text="consultation.consultation_type"></p>
                            </div>
                            <div class="flex items-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                    :class="getStatusColor(consultation.status)"
                                    x-text="consultation.status"></span>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function dashboardData() {
    return {
        stats: {},
        recent_applications: [],
        recent_bookings: [],
        recent_consultations: [],
        
        async init() {
            await this.loadData();
            this.initCharts();
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
                this.recent_applications = data.recent_applications;
                this.recent_bookings = data.recent_bookings;
                this.recent_consultations = data.recent_consultations;
            } catch (error) {
                console.error('Error loading dashboard data:', error);
            }
        },
        
        initCharts() {
            // Revenue Chart
            const revenueCtx = document.getElementById('revenueChart').getContext('2d');
            new Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [{
                        label: 'Revenue',
                        data: [12000, 19000, 15000, 25000, 22000, 30000, 28000, 35000, 32000, 40000, 38000, 45000],
                        borderColor: 'rgb(99, 102, 241)',
                        backgroundColor: 'rgba(99, 102, 241, 0.1)',
                        tension: 0.1
                    }]
                }
            });

            // Status Chart
            const statusCtx = document.getElementById('statusChart').getContext('2d');
            new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Pending', 'Under Review', 'Approved', 'Completed'],
                    datasets: [{
                        data: [30, 25, 20, 25],
                        backgroundColor: [
                            'rgb(250, 204, 21)',
                            'rgb(59, 130, 246)',
                            'rgb(34, 197, 94)',
                            'rgb(168, 85, 247)'
                        ]
                    }]
                }
            });
        },
        
        getStatusColor(status) {
            const colors = {
                'pending': 'bg-yellow-100 text-yellow-800',
                'under_review': 'bg-blue-100 text-blue-800',
                'approved': 'bg-green-100 text-green-800',
                'completed': 'bg-purple-100 text-purple-800',
                'rejected': 'bg-red-100 text-red-800'
            };
            return colors[status] || 'bg-gray-100 text-gray-800';
        }
    }
}
</script>