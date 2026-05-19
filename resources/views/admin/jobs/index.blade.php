<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Job Postings') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="w-full text-left">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="p-4">Title</th>
                            <th class="p-4">Company</th>
                            <th class="p-4">Status</th>
                            <th class="p-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jobs as $job)
                        <tr class="border-t">
                            <td class="p-4">
                                <div class="font-bold text-gray-900">{{ $job->title }}</div>
                                <div class="text-xs text-gray-500">{{ $job->category->name }}</div>
                            </td>
                            <td class="p-4 font-medium text-gray-700">{{ $job->company->name }}</td>
                            <td class="p-4">
                                <span class="px-2 py-1 rounded text-xs {{ $job->status === 'approved' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                    {{ ucfirst($job->status) }}
                                </span>
                            </td>
                            <td class="p-4">
                                @if($job->status === 'pending')
                                <form action="{{ route('admin.jobs.approve', $job) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-xs bg-green-600 text-white px-3 py-1 rounded font-bold hover:bg-green-700">Approve</button>
                                </form>
                                @endif
                                <a href="{{ route('jobs.show', $job) }}" class="text-xs bg-gray-200 text-gray-700 px-3 py-1 rounded font-bold ml-2">View</a>
                                <form action="{{ route('institute.jobs.destroy', $job) }}" method="POST" class="inline ml-2" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs bg-red-600 text-white px-3 py-1 rounded font-bold hover:bg-red-700">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @if($jobs->isEmpty())
                    <p class="p-6 text-center text-gray-500">No job postings found.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
