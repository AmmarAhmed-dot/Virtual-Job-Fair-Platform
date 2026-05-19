<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('institute.jobs.index') }}" class="text-gray-500 hover:text-gray-700 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Post a New Job') }}
            </h2>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-sm border">
                <form action="{{ route('institute.jobs.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block font-bold mb-2">Job Title</label>
                        <input type="text" name="title" class="w-full border-gray-300 rounded" required>
                    </div>
                    <div class="mb-4">
                        <label class="block font-bold mb-2">Category</label>
                        <select name="category_id" class="w-full border-gray-300 rounded" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block font-bold mb-2">Location</label>
                            <input type="text" name="location" class="w-full border-gray-300 rounded" required placeholder="e.g. Lahore, Remote">
                        </div>
                        <div>
                            <label class="block font-bold mb-2">Job Type</label>
                            <select name="type" class="w-full border-gray-300 rounded" required>
                                <option value="Full-time">Full-time</option>
                                <option value="Part-time">Part-time</option>
                                <option value="Contract">Contract</option>
                                <option value="Remote">Remote</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="block font-bold mb-2">Salary Range (Optional)</label>
                        <input type="text" name="salary" class="w-full border-gray-300 rounded" placeholder="e.g. 50k - 70k">
                    </div>
                    <div class="mb-4">
                        <label class="block font-bold mb-2">Job Description</label>
                        <textarea name="description" class="w-full border-gray-300 rounded" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded font-bold hover:bg-indigo-700">Submit Job Posting</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
