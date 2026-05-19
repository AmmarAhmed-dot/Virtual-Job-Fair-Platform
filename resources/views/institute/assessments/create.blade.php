<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <a href="{{ route('institute.jobs.index') }}" class="text-gray-500 hover:text-gray-700 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Create Assessment') }}
                </h2>
            </div>
            <span class="text-sm font-semibold text-gray-500 bg-gray-100 px-3 py-1 rounded-full border">
                Job: <strong class="text-indigo-600">{{ $job->title }}</strong>
            </span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100" x-data="{ 
                     questions: [
                         { question_text: '', option_a: '', option_b: '', option_c: '', option_d: '', correct_option: 'A' }
                     ],
                     addQuestion() {
                         this.questions.push({ question_text: '', option_a: '', option_b: '', option_c: '', option_d: '', correct_option: 'A' });
                     },
                     removeQuestion(index) {
                         if (this.questions.length > 1) {
                             this.questions.splice(index, 1);
                         }
                     }
                 }">

                <form action="{{ route('institute.assessments.store', $job) }}" method="POST" class="space-y-8">
                    @csrf

                    <!-- Assessment Header Info -->
                    <div class="border-b pb-6">
                        <label class="block text-lg font-extrabold text-gray-800 mb-2">Assessment Title</label>
                        <input type="text" name="title"
                            class="w-full border-gray-300 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 shadow-sm text-sm"
                            required placeholder="e.g. Technical Skills Assessment (HTML/CSS)">
                        <p class="text-xs text-gray-400 mt-2">This assessment will be assigned to all candidates
                            applying for the <strong>{{ $job->title }}</strong> role.</p>
                    </div>

                    <!-- Questions List -->
                    <div>
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-bold text-gray-900">Questions & Choices</h3>
                            <button type="button" @click="addQuestion()"
                                class="inline-flex items-center space-x-2 bg-indigo-50 text-indigo-700 px-4 py-2 rounded-xl text-xs font-bold hover:bg-indigo-100 transition border border-indigo-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                                <span>Add Question</span>
                            </button>
                        </div>

                        <div class="space-y-6">
                            <template x-for="(question, index) in questions" :key="index">
                                <div
                                    class="bg-gray-50/50 p-6 rounded-2xl border border-gray-200/60 relative hover:border-gray-300 transition duration-200">

                                    <!-- Delete Button -->
                                    <button type="button" @click="removeQuestion(index)"
                                        class="absolute top-4 right-4 text-red-500 hover:text-red-700 text-xs font-bold flex items-center space-x-1 bg-white border border-red-100 hover:border-red-200 px-2.5 py-1.5 rounded-lg shadow-sm transition"
                                        x-show="questions.length > 1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                        <span>Remove</span>
                                    </button>

                                    <!-- Question Label -->
                                    <div class="flex items-center space-x-2 mb-4">
                                        <span
                                            class="w-6 h-6 bg-indigo-600 text-white rounded-full flex items-center justify-center text-xs font-bold"
                                            x-text="index + 1"></span>
                                        <span class="font-extrabold text-sm text-gray-700">Question Item</span>
                                    </div>

                                    <!-- Question Input -->
                                    <div class="mb-4">
                                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1.5">Question
                                            Text</label>
                                        <input type="text" :name="`questions[${index}][question_text]`"
                                            x-model="question.question_text"
                                            class="w-full border-gray-300 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-sm shadow-sm"
                                            required placeholder="Write the question prompt here...">
                                    </div>

                                    <!-- Option Inputs -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1.5">Option
                                                A</label>
                                            <input type="text" :name="`questions[${index}][option_a]`"
                                                x-model="question.option_a"
                                                class="w-full border-gray-300 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                                                required placeholder="Option A">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1.5">Option
                                                B</label>
                                            <input type="text" :name="`questions[${index}][option_b]`"
                                                x-model="question.option_b"
                                                class="w-full border-gray-300 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                                                required placeholder="Option B">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1.5">Option
                                                C</label>
                                            <input type="text" :name="`questions[${index}][option_c]`"
                                                x-model="question.option_c"
                                                class="w-full border-gray-300 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                                                required placeholder="Option C">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1.5">Option
                                                D</label>
                                            <input type="text" :name="`questions[${index}][option_d]`"
                                                x-model="question.option_d"
                                                class="w-full border-gray-300 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                                                required placeholder="Option D">
                                        </div>
                                    </div>

                                    <!-- Correct Option Select -->
                                    <div class="mt-4">
                                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1.5">Correct
                                            Answer</label>
                                        <select :name="`questions[${index}][correct_option]`"
                                            x-model="question.correct_option"
                                            class="w-full border-gray-300 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                            <option value="A">Option A</option>
                                            <option value="B">Option B</option>
                                            <option value="C">Option C</option>
                                            <option value="D">Option D</option>
                                        </select>
                                    </div>

                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-between border-t pt-6">
                        <a href="{{ route('institute.jobs.index') }}"
                            class="text-sm font-semibold text-gray-500 hover:text-gray-700">Cancel & Return</a>
                        <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3.5 rounded-xl font-bold transition shadow-lg shadow-indigo-100 flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4">
                                </path>
                            </svg>
                            <span>Save Assessment</span>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>