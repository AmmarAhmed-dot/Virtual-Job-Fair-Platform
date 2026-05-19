<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('institute.jobs.index') }}" class="text-gray-500 hover:text-gray-700 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Job Applicants') }} {{ $job ? ' - ' . $job->title : '' }}
            </h2>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="w-full text-left">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="p-4">Candidate</th>
                            <th class="p-4">Job</th>
                            <th class="p-4">Status</th>
                            <th class="p-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($applications as $application)
                        <tr class="border-t">
                            <td class="p-4">
                                <div class="font-bold">{{ $application->user->name }}</div>
                                <div class="text-xs text-gray-500">{{ $application->user->email }}</div>
                            </td>
                            <td class="p-4 text-sm">{{ $application->jobPosting->title }}</td>
                            <td class="p-4">
                                <span class="px-2 py-1 rounded text-xs {{ $application->status === 'hired' ? 'bg-green-100 text-green-700' : ($application->status === 'rejected' ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700') }}">
                                    {{ ucfirst($application->status) }}
                                </span>
                            </td>
                            <td class="p-4">
                                <form x-data="{ status: '{{ $application->status }}' }" action="{{ route('institute.applications.update', $application) }}" method="POST" class="inline-flex flex-col space-y-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" x-model="status" class="text-xs border-gray-300 rounded">
                                        <option value="applied">Applied</option>
                                        <option value="interviewing">Interviewing</option>
                                        <option value="hired">Hired</option>
                                        <option value="rejected">Rejected</option>
                                    </select>
                                    <div x-show="status === 'interviewing'" class="flex flex-col space-y-1.5 mt-1">
                                        <label class="text-[10px] font-bold text-gray-500 uppercase">Interview Time</label>
                                        <input type="datetime-local" name="interview_at" value="{{ $application->interview_at }}" class="text-xs border-gray-300 rounded">
                                        <label class="text-[10px] font-bold text-gray-500 uppercase mt-1">Meeting Link</label>
                                        <input type="url" name="meeting_link" value="{{ $application->meeting_link }}" class="text-xs border-gray-300 rounded" placeholder="https://zoom.us/j/...">
                                    </div>
                                    <button type="submit" class="bg-indigo-600 text-white text-xs py-1 rounded font-bold hover:bg-indigo-700 mt-1">Update</button>
                                </form>
                                <a href="{{ route('institute.applicants.cv', $application->user) }}" class="text-xs bg-indigo-600 text-white px-2 py-1 rounded ml-2 font-bold hover:bg-indigo-700">View CV</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @if($applications->isEmpty())
                    <p class="p-6 text-center text-gray-500 font-medium">No candidates have applied for this job yet.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
