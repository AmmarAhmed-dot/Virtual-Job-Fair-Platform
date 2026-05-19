<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('My Job Postings') }}
            </h2>
            <a href="{{ route('institute.jobs.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded text-sm font-bold">Post New Job</a>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="w-full text-left">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="p-4">Title</th>
                            <th class="p-4">Category</th>
                            <th class="p-4">Status</th>
                            <th class="p-4">Date</th>
                            <th class="p-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jobs as $job)
                        <tr class="border-t">
                            <td class="p-4 font-bold">{{ $job->title }}</td>
                            <td class="p-4">{{ $job->category->name }}</td>
                            <td class="p-4">
                                <span class="px-2 py-1 rounded text-xs {{ $job->status === 'approved' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                    {{ ucfirst($job->status) }}
                                </span>
                            </td>
                            <td class="p-4 text-sm text-gray-500">{{ $job->created_at->format('M d, Y') }}</td>
                            <td class="p-4">
                                <a href="{{ route('institute.applicants', $job) }}" class="text-xs bg-indigo-600 text-white px-3 py-1 rounded font-bold">Applicants</a>
                                <a href="{{ route('institute.assessments.create', $job) }}" class="text-xs bg-purple-600 text-white px-3 py-1 rounded font-bold ml-1">Assessment</a>
                                <a href="{{ route('jobs.show', $job) }}" class="text-xs bg-gray-200 text-gray-700 px-3 py-1 rounded font-bold ml-1">View</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @if($jobs->isEmpty())
                    <p class="p-6 text-center text-gray-500">No jobs posted yet.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
