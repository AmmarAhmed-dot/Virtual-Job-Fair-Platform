<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('candidate.applications') }}" class="text-gray-500 hover:text-gray-700 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Assessment:') }} {{ $assessment->title }}
            </h2>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-sm border">
                <form action="{{ route('candidate.assessments.submit', $job) }}" method="POST">
                    @csrf
                    @foreach($assessment->questions as $index => $question)
                    <div class="mb-8 p-4 bg-gray-50 rounded">
                        <h3 class="font-bold mb-4">{{ $index + 1 }}. {{ $question->question_text }}</h3>
                        <div class="space-y-2">
                            <label class="flex items-center space-x-3">
                                <input type="radio" name="answers[{{ $index }}]" value="A" required class="text-indigo-600">
                                <span>{{ $question->option_a }}</span>
                            </label>
                            <label class="flex items-center space-x-3">
                                <input type="radio" name="answers[{{ $index }}]" value="B" required class="text-indigo-600">
                                <span>{{ $question->option_b }}</span>
                            </label>
                            <label class="flex items-center space-x-3">
                                <input type="radio" name="answers[{{ $index }}]" value="C" required class="text-indigo-600">
                                <span>{{ $question->option_c }}</span>
                            </label>
                            <label class="flex items-center space-x-3">
                                <input type="radio" name="answers[{{ $index }}]" value="D" required class="text-indigo-600">
                                <span>{{ $question->option_d }}</span>
                            </label>
                        </div>
                    </div>
                    @endforeach
                    <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-lg font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition">Submit Assessment</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
