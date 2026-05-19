<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('institute.jobs.index') }}" class="text-gray-500 hover:text-gray-700 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
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
                            <th class="p-4">Current Status</th>
                            <th class="p-4">Update Status</th>
                            <th class="p-4">CV & GitHub</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($applications as $application)
                            <tr class="border-t">
                                <td class="p-4">
                                    <div class="font-bold text-gray-900">{{ $application->user->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $application->user->email }}</div>
                                </td>
                                <td class="p-4 text-sm text-gray-700">{{ $application->jobPosting->title }}</td>
                                <td class="p-4">
                                    <span
                                        class="px-2 py-1 rounded text-xs font-semibold {{ $application->status === 'hired' ? 'bg-green-100 text-green-700' : ($application->status === 'rejected' ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700') }}">
                                        {{ ucfirst($application->status) }}
                                    </span>
                                </td>
                                <td class="p-4">
                                    <form x-data="{ status: '{{ $application->status }}' }"
                                        action="{{ route('institute.applications.update', $application) }}" method="POST"
                                        class="inline-flex flex-col space-y-1.5 min-w-[150px]">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" x-model="status" class="text-xs border-gray-300 rounded py-1 px-2">
                                            <option value="applied">Applied</option>
                                            <option value="interviewing">Interviewing</option>
                                            <option value="hired">Hired</option>
                                            <option value="rejected">Rejected</option>
                                        </select>
                                        <div x-show="status === 'interviewing'" class="flex flex-col space-y-1 mt-1">
                                            <label class="text-[9px] font-bold text-gray-500 uppercase">Interview Time</label>
                                            <input type="datetime-local" name="interview_at"
                                                value="{{ $application->interview_at }}"
                                                class="text-xs border-gray-300 rounded p-1">
                                            <label class="text-[9px] font-bold text-gray-500 uppercase mt-1">Meeting Link</label>
                                            <input type="url" name="meeting_link" value="{{ $application->meeting_link }}"
                                                class="text-xs border-gray-300 rounded p-1" placeholder="https://zoom.us/j/...">
                                        </div>
                                        <button type="submit"
                                            class="bg-indigo-600 text-white text-xs py-1.5 rounded font-bold hover:bg-indigo-700 transition">Update</button>
                                    </form>
                                </td>
                                <td class="p-4">
                                    <div class="flex flex-col space-y-1.5 min-w-[130px]">
                                        @if($application->user->cvData)
                                            <a href="{{ route('institute.applicants.cv', $application->user) }}"
                                                class="text-xs text-center bg-indigo-600 text-white px-3 py-2 rounded font-bold hover:bg-indigo-700 transition shadow-sm">View CV</a>
                                            @if($application->user->cvData->github_username)
                                                <a href="{{ route('institute.applicants.github', $application->user) }}"
                                                    class="text-xs text-center bg-slate-800 text-white px-3 py-2 rounded font-bold hover:bg-slate-700 transition flex items-center justify-center space-x-1.5 shadow-sm">
                                                    <svg class="w-3.5 h-3.5 text-indigo-400 fill-current" viewBox="0 0 24 24">
                                                        <path fill-rule="evenodd"
                                                            d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                    <span>GitHub Analysis</span>
                                                </a>
                                            @endif
                                        @else
                                            <span class="text-xs text-center text-gray-400 italic px-2 py-1.5 bg-gray-50 border border-dashed rounded">No CV Built</span>
                                        @endif
                                    </div>
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