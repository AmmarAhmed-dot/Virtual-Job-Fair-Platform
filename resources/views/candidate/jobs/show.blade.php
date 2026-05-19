<x-app-layout>
    @php
        $backUrl = route('jobs.index');
        if (auth()->check()) {
            if (auth()->user()->role === 'admin') {
                $backUrl = route('admin.jobs.index');
            } elseif (auth()->user()->role === 'institute') {
                $backUrl = route('institute.jobs.index');
            }
        }
    @endphp
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ $backUrl }}" class="text-gray-500 hover:text-gray-700 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $job->title }}
            </h2>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 rounded-lg shadow-sm border">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="flex justify-between items-start mb-8">
                    <div>
                        <h1 class="text-3xl font-extrabold text-gray-900 mb-2">{{ $job->title }}</h1>
                        <p class="text-xl text-indigo-600 font-bold">{{ $job->company->name }}</p>
                    </div>
                    @if(auth()->user()->role === 'candidate')
                    <form action="{{ route('jobs.apply', $job) }}" method="POST">
                        @csrf
                        @php
                            $alreadyApplied = auth()->user()->applications()->where('job_posting_id', $job->id)->exists();
                        @endphp
                        @if($alreadyApplied)
                            <button type="button" disabled class="bg-gray-300 text-gray-600 px-8 py-3 rounded-lg font-bold cursor-not-allowed">Already Applied</button>
                        @else
                            <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-lg font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">Apply Now</button>
                        @endif
                    </form>
                    @endif
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8 py-6 border-y border-gray-100">
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-bold mb-1">Location</p>
                        <p class="font-bold text-gray-800">{{ $job->location }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-bold mb-1">Job Type</p>
                        <p class="font-bold text-gray-800">{{ $job->type }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-bold mb-1">Category</p>
                        <p class="font-bold text-gray-800">{{ $job->category->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-bold mb-1">Salary</p>
                        <p class="font-bold text-gray-800">{{ $job->salary ?? 'Negotiable' }}</p>
                    </div>
                </div>
                <div class="prose max-w-none text-gray-700 leading-relaxed">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Job Description</h3>
                    {!! nl2br(e($job->description)) !!}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
