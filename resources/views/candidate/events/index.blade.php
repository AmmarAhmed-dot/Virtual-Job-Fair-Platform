<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Virtual Events & Webinars') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($events as $event)
                <div class="bg-white p-6 rounded-xl shadow-sm border hover:shadow-md transition">
                    <span class="bg-indigo-50 text-indigo-700 text-xs px-2.5 py-1 rounded-full font-bold uppercase tracking-wider mb-4 inline-block">Webinar / Event</span>
                    <h3 class="font-extrabold text-xl text-gray-900 mb-2">{{ $event->title }}</h3>
                    <p class="text-sm text-gray-500 mb-4">Hosted by: <strong class="text-indigo-600">{{ $event->company->name ?? 'VJFP Recruiter' }}</strong></p>
                    <p class="text-gray-600 mb-6 text-sm line-clamp-3">{{ $event->description ?? 'No description provided.' }}</p>
                    <div class="flex justify-between items-center border-t pt-4">
                        <span class="text-xs font-bold text-gray-500 uppercase">
                            {{ \Carbon\Carbon::parse($event->scheduled_at)->format('M d, Y @ h:i A') }}
                        </span>
                        <a href="{{ route('events.room', $event) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-100">Join Virtual Room</a>
                    </div>
                </div>
                @endforeach
            </div>
            @if($events->isEmpty())
                <div class="bg-white p-16 rounded-2xl text-center shadow-sm border border-gray-100">
                    <div class="w-16 h-16 bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">No Active Events</h3>
                    <p class="text-gray-500 max-w-md mx-auto">There are no virtual career fairs or webinars scheduled at the moment. Please check back later!</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
