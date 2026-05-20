<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('events.index') }}" class="text-gray-500 hover:text-gray-700 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Event / Webinar') }}
            </h2>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-sm border">
                @if ($errors->any())
                    <div class="mb-4 text-red-600 text-sm">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('events.update', $event) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label class="block font-bold mb-2">Event Title</label>
                        <input type="text" name="title" value="{{ old('title', $event->title) }}" class="w-full border-gray-300 rounded" required placeholder="e.g. Virtual Tech Career Fair 2026">
                    </div>
                    <div class="mb-4">
                        <label for="scheduled_at" class="block font-bold mb-2">Scheduled Date & Time</label>
                        <input type="datetime-local" name="scheduled_at" id="scheduled_at" value="{{ \Carbon\Carbon::parse($event->scheduled_at)->format('Y-m-d\TH:i') }}" required class="w-full border-gray-300 rounded focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div class="mb-4">
                        <label class="block font-bold mb-2">Description</label>
                        <textarea name="description" class="w-full border-gray-300 rounded" rows="5" placeholder="Details about the event...">{{ old('description', $event->description) }}</textarea>
                    </div>
                    <div class="flex items-center space-x-4">
                        <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded font-bold hover:bg-indigo-700">Update Event</button>
                        <a href="{{ route('events.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
