<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('My Events / Webinars') }}
            </h2>
            <a href="{{ route('events.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded text-sm font-bold">Schedule Event</a>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="w-full text-left">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="p-4">Title</th>
                            <th class="p-4">Scheduled At</th>
                            <th class="p-4">Link</th>
                            <th class="p-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($events as $event)
                        <tr class="border-t">
                            <td class="p-4 font-bold text-gray-900">{{ $event->title }}</td>
                            <td class="p-4">{{ \Carbon\Carbon::parse($event->scheduled_at)->format('M d, Y @ h:i A') }}</td>
                            <td class="p-4">
                                @if($event->link)
                                    <a href="{{ $event->link }}" target="_blank" class="text-indigo-600 underline hover:text-indigo-800">{{ $event->link }}</a>
                                @else
                                    <span class="text-gray-400">No Link</span>
                                @endif
                            </td>
                            <td class="p-4 text-right space-x-2">
                                <a href="{{ route('events.edit', $event) }}" class="text-xs bg-gray-200 text-gray-700 px-3 py-1.5 rounded font-bold hover:bg-gray-300">Edit</a>
                                <form action="{{ route('events.destroy', $event) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs bg-red-100 text-red-600 px-3 py-1.5 rounded font-bold hover:bg-red-200" onclick="return confirm('Are you sure you want to delete this event?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @if($events->isEmpty())
                    <div class="p-12 text-center text-gray-500">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <p class="text-lg font-bold">No Scheduled Events</p>
                        <p class="text-sm text-gray-400 mt-1">You haven't scheduled any webinars or career fairs yet.</p>
                        <a href="{{ route('events.create') }}" class="mt-4 inline-block bg-indigo-600 text-white text-xs px-4 py-2 rounded-lg font-bold hover:bg-indigo-700">Schedule One Now</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
