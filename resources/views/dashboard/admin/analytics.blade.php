@extends('layouts.dashboard')

@section('title', 'Analytics Dashboard')

@section('header', 'Analytics Dashboard')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Analytics Header -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Analytics Dashboard</h1>
            <p class="text-gray-600">Monitor application trends, revenue, and business metrics</p>
        </div>

        <!-- Date Range Filter -->
        <div class="bg-white shadow rounded-lg p-4 mb-6">
            <div class="flex flex-wrap gap-4 items-center">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date Range</label>
                    <select id="dateRange" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="7">Last 7 days</option>
                        <option value="30" selected>Last 30 days</option>
                        <option value="90">Last 90 days</option>
                        <option value="365">Last year</option>
                    </select>
                </div>
                <div class="flex-1">
                    <button onclick="refreshAnalytics()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                        <i class="fas fa-sync-alt mr-2"></i>Refresh Data
                    </button>
                </div>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                                <i class="fas fa-chart-line text-white"></i>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Applications</dt>
                                <dd class="text-lg font-semibold text-gray-900" id="totalApplications">-</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                                <i class="fas fa-dollar-sign text-white"></i>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Revenue</dt>
                                <dd class="text-lg font-semibold text-gray-900" id="totalRevenue">-</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                                <i class="fas fa-percentage text-white"></i>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Conversion Rate</dt>
                                <dd class="text-lg font-semibold text-gray-900" id="conversionRate">-</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-purple-500 rounded-md flex items-center justify-center">
                                <i class="fas fa-users text-white"></i>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Active Users</dt>
                                <dd class="text-lg font-semibold text-gray-900" id="activeUsers">-</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Application Trends -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Application Trends</h3>
                <div class="h-64">
                    <canvas id="trendsChart"></canvas>
                </div>
            </div>

            <!-- Revenue by Type -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Revenue by Type</h3>
                <div class="h-64">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Status Distribution -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Visa Application Status</h3>
                <div class="h-48">
                    <canvas id="visaStatusChart"></canvas>
                </div>
            </div>

            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Student Application Status</h3>
                <div class="h-48">
                    <canvas id="studentStatusChart"></canvas>
                </div>
            </div>

            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Booking Status</h3>
                <div class="h-48">
                    <canvas id="bookingStatusChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Monthly Revenue -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Monthly Revenue Trend</h3>
            <div class="h-64">
                <canvas id="monthlyRevenueChart"></canvas>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
let trendsChart, revenueChart, visaStatusChart, studentStatusChart, bookingStatusChart, monthlyRevenueChart;

function initCharts() {
    // Trends Chart
    const trendsCtx = document.getElementById('trendsChart').getContext('2d');
    trendsChart = new Chart(trendsCtx, {
        type: 'line',
        data: {
            labels: [],
            datasets: [
                {
                    label: 'Visa Applications',
                    data: [],
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.1
                },
                {
                    label: 'Student Applications',
                    data: [],
                    borderColor: 'rgb(16, 185, 129)',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    tension: 0.1
                },
                {
                    label: 'Bookings',
                    data: [],
                    borderColor: 'rgb(251, 146, 60)',
                    backgroundColor: 'rgba(251, 146, 60, 0.1)',
                    tension: 0.1
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    revenueChart = new Chart(revenueCtx, {
        type: 'doughnut',
        data: {
            labels: ['Visa', 'Student', 'Booking'],
            datasets: [{
                data: [],
                backgroundColor: [
                    'rgb(59, 130, 246)',
                    'rgb(16, 185, 129)',
                    'rgb(251, 146, 60)'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    // Status Charts
    const visaStatusCtx = document.getElementById('visaStatusChart').getContext('2d');
    visaStatusChart = new Chart(visaStatusCtx, {
        type: 'pie',
        data: {
            labels: [],
            datasets: [{
                data: [],
                backgroundColor: [
                    'rgb(34, 197, 94)',
                    'rgb(251, 146, 60)',
                    'rgb(239, 68, 68)',
                    'rgb(156, 163, 175)'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    const studentStatusCtx = document.getElementById('studentStatusChart').getContext('2d');
    studentStatusChart = new Chart(studentStatusCtx, {
        type: 'pie',
        data: {
            labels: [],
            datasets: [{
                data: [],
                backgroundColor: [
                    'rgb(34, 197, 94)',
                    'rgb(251, 146, 60)',
                    'rgb(239, 68, 68)',
                    'rgb(156, 163, 175)'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    const bookingStatusCtx = document.getElementById('bookingStatusChart').getContext('2d');
    bookingStatusChart = new Chart(bookingStatusCtx, {
        type: 'pie',
        data: {
            labels: [],
            datasets: [{
                data: [],
                backgroundColor: [
                    'rgb(34, 197, 94)',
                    'rgb(251, 146, 60)',
                    'rgb(239, 68, 68)',
                    'rgb(156, 163, 175)'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    // Monthly Revenue Chart
    const monthlyRevenueCtx = document.getElementById('monthlyRevenueChart').getContext('2d');
    monthlyRevenueChart = new Chart(monthlyRevenueCtx, {
        type: 'bar',
        data: {
            labels: [],
            datasets: [{
                label: 'Monthly Revenue',
                data: [],
                backgroundColor: 'rgba(59, 130, 246, 0.8)',
                borderColor: 'rgb(59, 130, 246)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '$' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });
}

function loadAnalyticsData() {
    fetch('{{ route("admin.analytics.data") }}')
        .then(response => response.json())
        .then(data => {
            updateTrendsChart(data);
            updateRevenueChart(data);
            updateStatusCharts(data);
            updateMonthlyRevenueChart(data);
            updateSummaryCards(data);
        })
        .catch(error => {
            console.error('Error loading analytics data:', error);
        });
}

function updateTrendsChart(data) {
    const dates = [...new Set([
        ...data.visa_trends.map(item => item.date),
        ...data.student_trends.map(item => item.date),
        ...data.booking_trends.map(item => item.date)
    ])].sort();

    trendsChart.data.labels = dates;
    trendsChart.data.datasets[0].data = dates.map(date => {
        const item = data.visa_trends.find(t => t.date === date);
        return item ? item.count : 0;
    });
    trendsChart.data.datasets[1].data = dates.map(date => {
        const item = data.student_trends.find(t => t.date === date);
        return item ? item.count : 0;
    });
    trendsChart.data.datasets[2].data = dates.map(date => {
        const item = data.booking_trends.find(t => t.date === date);
        return item ? item.count : 0;
    });
    trendsChart.update();
}

function updateRevenueChart(data) {
    revenueChart.data.datasets[0].data = data.revenue_by_type.map(item => item.total);
    revenueChart.update();
}

function updateStatusCharts(data) {
    // Visa Status
    visaStatusChart.data.labels = data.visa_status_distribution.map(item => item.status);
    visaStatusChart.data.datasets[0].data = data.visa_status_distribution.map(item => item.count);
    visaStatusChart.update();

    // Student Status
    studentStatusChart.data.labels = data.student_status_distribution.map(item => item.status);
    studentStatusChart.data.datasets[0].data = data.student_status_distribution.map(item => item.count);
    studentStatusChart.update();

    // Booking Status
    bookingStatusChart.data.labels = data.booking_status_distribution.map(item => item.status);
    bookingStatusChart.data.datasets[0].data = data.booking_status_distribution.map(item => item.count);
    bookingStatusChart.update();
}

function updateMonthlyRevenueChart(data) {
    const monthLabels = data.monthly_revenue.map(item => {
        const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        return monthNames[item.month - 1] + ' ' + item.year;
    });

    monthlyRevenueChart.data.labels = monthLabels;
    monthlyRevenueChart.data.datasets[0].data = data.monthly_revenue.map(item => item.total);
    monthlyRevenueChart.update();
}

function updateSummaryCards(data) {
    // Calculate totals
    const totalVisaApps = data.visa_trends.reduce((sum, item) => sum + item.count, 0);
    const totalStudentApps = data.student_trends.reduce((sum, item) => sum + item.count, 0);
    const totalBookings = data.booking_trends.reduce((sum, item) => sum + item.count, 0);
    const totalApplications = totalVisaApps + totalStudentApps + totalBookings;
    const totalRevenue = data.revenue_by_type.reduce((sum, item) => sum + item.total, 0);

    document.getElementById('totalApplications').textContent = totalApplications.toLocaleString();
    document.getElementById('totalRevenue').textContent = '$' + totalRevenue.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
    
    // Calculate conversion rate (completed applications / total applications)
    const completedVisa = data.visa_status_distribution.find(s => s.status === 'approved')?.count || 0;
    const completedStudent = data.student_status_distribution.find(s => s.status === 'approved')?.count || 0;
    const completedBooking = data.booking_status_distribution.find(s => s.status === 'confirmed')?.count || 0;
    const completedTotal = completedVisa + completedStudent + completedBooking;
    const conversionRate = totalApplications > 0 ? ((completedTotal / totalApplications) * 100).toFixed(1) : 0;
    document.getElementById('conversionRate').textContent = conversionRate + '%';
    
    // Active users (placeholder - you might want to implement this based on your user activity tracking)
    document.getElementById('activeUsers').textContent = totalApplications > 0 ? Math.floor(totalApplications * 0.7) : 0;
}

function refreshAnalytics() {
    loadAnalyticsData();
}

// Initialize everything when page loads
document.addEventListener('DOMContentLoaded', function() {
    initCharts();
    loadAnalyticsData();

    // Refresh data every 5 minutes
    setInterval(loadAnalyticsData, 300000);
});
</script>
@endpush
@endsection