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
        </div>
    </div>
</x-app-layout>
