<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Candidate Dashboard') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div class="bg-white p-6 rounded-lg shadow-sm border">
                    <h3 class="font-bold text-lg mb-2">My Applications</h3>
                    <p class="text-3xl font-extrabold text-indigo-600">{{ $stats['my_applications'] }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm border">
                    <h3 class="font-bold text-lg mb-2">Jobs Applied</h3>
                    <p class="text-3xl font-extrabold text-green-600">{{ $stats['my_applications'] }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm border">
                    <h3 class="font-bold text-lg mb-2">Profile Completeness</h3>
                    <p class="text-3xl font-extrabold text-orange-600">{{ $stats['profile_completeness'] }}%</p>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($analysis)
                        <div class="mb-8 p-6 bg-indigo-50 rounded-2xl border border-indigo-100">
                            <h3 class="text-xl font-bold mb-4 text-indigo-800 flex items-center">
                                <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"></path></svg>
                                AI GitHub Profile Analysis
                            </h3>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-4">
                                <div class="bg-white p-4 rounded-xl shadow-sm">
                                    <p class="text-xs text-gray-500 uppercase font-bold">Code Score</p>
                                    <p class="text-2xl font-black text-indigo-600">{{ $analysis['score'] }}/100</p>
                                </div>
                                <div class="bg-white p-4 rounded-xl shadow-sm">
                                    <p class="text-xs text-gray-500 uppercase font-bold">Public Repos</p>
                                    <p class="text-2xl font-black text-indigo-600">{{ $analysis['repos'] }}</p>
                                </div>
                            </div>
                            <p class="text-indigo-900 font-medium leading-relaxed italic">"{{ $analysis['summary'] }}"</p>
                        </div>
                    @endif
                    <h3 class="font-bold mb-4">Quick Links</h3>
                    <div class="flex space-x-4">
                        <a href="{{ route('jobs.index') }}" class="bg-indigo-600 text-white px-4 py-2 rounded">Browse Jobs</a>
                        <a href="{{ route('candidate.cv-builder') }}" class="bg-indigo-600 text-white px-4 py-2 rounded">Build My CV</a>
                        <a href="{{ route('profile.edit') }}" class="bg-indigo-600 text-white px-4 py-2 rounded">My Profile</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
