<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Institute Dashboard') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div class="bg-white p-6 rounded-lg shadow-sm border">
                    <h3 class="font-bold text-lg mb-2">My Jobs</h3>
                    <p class="text-3xl font-extrabold text-indigo-600">{{ $stats['my_jobs'] }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm border">
                    <h3 class="font-bold text-lg mb-2">Total Applicants</h3>
                    <p class="text-3xl font-extrabold text-blue-600">{{ $stats['total_applicants'] }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm border">
                    <h3 class="font-bold text-lg mb-2">Scheduled Interviews</h3>
                    <p class="text-3xl font-extrabold text-purple-600">{{ $stats['scheduled_interviews'] }}</p>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="font-bold mb-4">Manage My Recruitment</h3>
                    <div class="flex space-x-4">
                        <a href="{{ route('institute.jobs.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded">Post New Job</a>
                        <a href="{{ route('institute.applicants') }}" class="bg-indigo-600 text-white px-4 py-2 rounded">View Applicants</a>
                        <a href="{{ route('events.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded">Create Event</a>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <div class="bg-white p-6 rounded-lg shadow-sm border">
                    <h3 class="font-bold mb-4 text-gray-700">Applicants by Status</h3>
                    <canvas id="applicationsStatusChart" height="200"></canvas>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm border">
                    <h3 class="font-bold mb-4 text-gray-700">Applicants by Job</h3>
                    <canvas id="applicationsJobChart" height="200"></canvas>
                </div>
            </div>

            <!-- Chart.js -->
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const statusCtx = document.getElementById('applicationsStatusChart');
                    const jobCtx = document.getElementById('applicationsJobChart');

                    const statusData = @json($chartData['applications_by_status']);
                    const jobData = @json($chartData['applications_by_job']);

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

                    if(jobCtx && Object.keys(jobData).length > 0) {
                        new Chart(jobCtx, {
                            type: 'bar',
                            data: {
                                labels: Object.keys(jobData),
                                datasets: [{
                                    label: 'Number of Applicants',
                                    data: Object.values(jobData),
                                    backgroundColor: '#34d399',
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
