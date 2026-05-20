<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('events.index') }}" class="text-gray-500 hover:text-gray-700 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Schedule New Event / Webinar') }}
            </h2>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-sm border">
                <form action="{{ route('events.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block font-bold mb-2">Event Title</label>
                        <input type="text" name="title" class="w-full border-gray-300 rounded" required placeholder="e.g. Virtual Tech Career Fair 2026">
                    </div>
                    <div class="mb-4">
                        <label for="scheduled_at" class="block font-bold mb-2">Scheduled Date & Time</label>
                        <input type="datetime-local" name="scheduled_at" id="scheduled_at" required class="w-full border-gray-300 rounded focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div class="mb-4">
                        <label class="block font-bold mb-2">Description</label>
                        <textarea name="description" class="w-full border-gray-300 rounded" rows="5" placeholder="Details about the event..."></textarea>
                    </div>
                    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded font-bold hover:bg-indigo-700">Schedule Event</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
