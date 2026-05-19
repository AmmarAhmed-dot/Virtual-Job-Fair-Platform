<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Available Jobs') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-sm border mb-8">
                <form action="{{ route('jobs.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search jobs by title or description..." class="flex-1 border-gray-300 rounded-lg">
                    <input type="text" name="location" value="{{ request('location') }}" placeholder="Location..." class="md:w-1/4 border-gray-300 rounded-lg">
                    <button type="submit" class="bg-indigo-600 text-white px-8 py-2 rounded-lg font-bold hover:bg-indigo-700 transition">Search</button>
                </form>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($jobs as $job)
                <div class="bg-white p-6 rounded-lg shadow-sm border hover:shadow-md transition">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="font-bold text-xl text-indigo-700">{{ $job->title }}</h3>
                            <p class="text-gray-600 font-medium">{{ $job->company->name }}</p>
                        </div>
                        <span class="bg-indigo-50 text-indigo-700 text-xs px-2 py-1 rounded font-bold uppercase">{{ $job->type }}</span>
                    </div>
                    <div class="flex items-center text-gray-500 text-sm mb-4 space-x-4">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            {{ $job->location }}
                        </span>
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                            {{ $job->category->name }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center mt-6">
                        <span class="text-lg font-bold text-gray-800">{{ $job->salary ?? 'Negotiable' }}</span>
                        <a href="{{ route('jobs.show', $job) }}" class="text-indigo-600 font-bold hover:underline">View Details →</a>
                    </div>
                </div>
                @endforeach
            </div>
            @if($jobs->isEmpty())
                <div class="bg-white p-12 rounded-lg text-center shadow-sm border">
                    <p class="text-gray-500 text-lg">No approved jobs found at the moment. Please check back later!</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
