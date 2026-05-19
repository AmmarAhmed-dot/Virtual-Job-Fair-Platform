<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Applications') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="w-full text-left">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="p-4">Job Title</th>
                            <th class="p-4">Company</th>
                            <th class="p-4">Status</th>
                            <th class="p-4">Applied Date</th>
                            <th class="p-4">Interview</th>
                            <th class="p-4">Quiz</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($applications as $application)
                        <tr class="border-t">
                            <td class="p-4 font-bold text-indigo-700">{{ $application->jobPosting->title }}</td>
                            <td class="p-4 font-medium text-gray-700">{{ $application->jobPosting->company->name }}</td>
                            <td class="p-4">
                                <span class="px-2 py-1 rounded text-xs {{ $application->status === 'hired' ? 'bg-green-100 text-green-700' : ($application->status === 'rejected' ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700') }}">
                                    {{ ucfirst($application->status) }}
                                </span>
                            </td>
                            <td class="p-4 text-sm text-gray-500">{{ $application->created_at->format('M d, Y') }}</td>
                            <td class="p-4">
                                @if($application->interview_at)
                                    <div class="text-xs font-bold text-indigo-600">
                                        {{ \Carbon\Carbon::parse($application->interview_at)->format('M d, Y @ h:i A') }}
                                    </div>
                                    @if($application->meeting_link)
                                        <a href="{{ $application->meeting_link }}" target="_blank" class="text-xs bg-indigo-600 text-white px-2 py-1 rounded mt-1 inline-block">Join Meeting</a>
                                    @endif
                                @else
                                    <span class="text-xs text-gray-400">Not scheduled</span>
                                @endif
                            </td>
                            <td class="p-4">
                                @php
                                    $assessment = \App\Models\Assessment::where('job_posting_id', $application->job_posting_id)->first();
                                @endphp
                                @if($assessment)
                                    @if($application->quiz_score !== null)
                                        <span class="text-xs font-bold text-green-600">Score: {{ $application->quiz_score }}</span>
                                    @else
                                        <a href="{{ route('candidate.assessments.take', $application->jobPosting) }}" class="text-xs bg-purple-600 text-white px-2 py-1 rounded font-bold">Take Quiz</a>
                                    @endif
                                @else
                                    <span class="text-xs text-gray-400">None</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @if($applications->isEmpty())
                    <p class="p-6 text-center text-gray-500">You haven't applied for any jobs yet. <a href="{{ route('jobs.index') }}" class="text-indigo-600 underline font-bold">Browse jobs now!</a></p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
