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
        </div>
    </div>
</x-app-layout>
