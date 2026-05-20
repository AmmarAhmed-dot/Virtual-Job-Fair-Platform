<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div class="bg-white p-6 rounded-lg shadow-sm border">
                    <h3 class="font-bold text-lg mb-2">Total Users</h3>
                    <p class="text-3xl font-extrabold text-indigo-600">{{ $stats['total_users'] }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm border">
                    <h3 class="font-bold text-lg mb-2">Pending Jobs</h3>
                    <p class="text-3xl font-extrabold text-yellow-600">{{ $stats['pending_jobs'] }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm border">
                    <h3 class="font-bold text-lg mb-2">Active Events</h3>
                    <p class="text-3xl font-extrabold text-green-600">{{ $stats['active_events'] }}</p>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="font-bold mb-4">Quick Actions</h3>
                    <div class="flex space-x-4">
                        <a href="{{ route('admin.categories.index') }}" class="bg-indigo-600 text-white px-4 py-2 rounded">Manage Categories</a>
                        <a href="{{ route('admin.jobs.index') }}" class="bg-indigo-600 text-white px-4 py-2 rounded">Approve Jobs</a>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <div class="bg-white p-6 rounded-lg shadow-sm border">
                    <h3 class="font-bold mb-4 text-gray-700">Applications by Status</h3>
                    <canvas id="applicationsStatusChart" height="200"></canvas>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm border">
                    <h3 class="font-bold mb-4 text-gray-700">Jobs by Category</h3>
                    <canvas id="jobsCategoryChart" height="200"></canvas>
                </div>
            </div>

            <!-- Chart.js -->
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const statusCtx = document.getElementById('applicationsStatusChart');
                    const categoryCtx = document.getElementById('jobsCategoryChart');

                    const statusData = @json($chartData['applications_by_status']);
                    const categoryData = @json($chartData['jobs_by_category']);

                    if(statusCtx && Object.keys(statusData).length > 0) {
                        new Chart(statusCtx, {
                            type: 'pie',
                            data: {
                                labels: Object.keys(statusData).map(k => k.charAt(0).toUpperCase() + k.slice(1)),
                                datasets: [{
                                    data: Object.values(statusData),
                                    backgroundColor: ['#818cf8', '#34d399', '#fbbf24', '#f87171'],
                                }]
                            }
                        });
                    }

                    if(categoryCtx && Object.keys(categoryData).length > 0) {
                        new Chart(categoryCtx, {
                            type: 'bar',
                            data: {
                                labels: Object.keys(categoryData),
                                datasets: [{
                                    label: 'Number of Jobs',
                                    data: Object.values(categoryData),
                                    backgroundColor: '#818cf8',
                                }]
                            },
                            options: {
                                scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
                            }
                        });
                    }
                });
            </script>
        </div>
    </div>
</x-app-layout>
