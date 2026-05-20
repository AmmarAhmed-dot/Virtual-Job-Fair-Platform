<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ url()->previous() }}" class="text-gray-500 hover:text-gray-700 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Virtual Event / Webinar Room') }} - {{ $event->title }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6 h-[80vh]">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 h-full flex flex-col">
            <div id="meeting-note" class="mb-4 bg-blue-50 border-l-4 border-blue-400 p-4 rounded-r-lg shadow-sm transition-opacity duration-500">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-700 font-medium" id="meeting-note-text">
                            <strong>Security Verification:</strong> To ensure a secure event environment, the event host must verify their identity. If prompted that moderators have not arrived, please click the <strong>Log-in</strong> button within the video window to authenticate and begin the event.
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-black overflow-hidden shadow-xl sm:rounded-2xl flex-1 border border-gray-700 relative">
                <!-- Fallback Loading State -->
                <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                    <div class="text-white text-center">
                        <svg class="w-10 h-10 animate-spin mx-auto text-indigo-500 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        <p class="font-bold text-sm tracking-widest uppercase">Connecting to secure event room...</p>
                    </div>
                </div>
                
                <div id="meet" class="w-full h-full relative z-10"></div>
            </div>
        </div>
    </div>

    <!-- Jitsi Meet API -->
    <script src="https://meet.jit.si/external_api.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const domain = 'meet.jit.si';
            const options = {
                roomName: '{{ $roomName }}',
                width: '100%',
                height: '100%',
                parentNode: document.querySelector('#meet'),
                lang: 'en',
                userInfo: {
                    displayName: '{{ $userName }}'
                },
                configOverwrite: {
                    defaultLanguage: 'en',
                    startWithAudioMuted: false,
                    startWithVideoMuted: false,
                    prejoinPageEnabled: false // Skip prejoin for faster connection
                },
                interfaceConfigOverwrite: {
                    SHOW_JITSI_WATERMARK: false,
                    SHOW_WATERMARK_FOR_GUESTS: false,
                    TOOLBAR_BUTTONS: [
                        'microphone', 'camera', 'closedcaptions', 'desktop', 'fullscreen',
                        'fodeviceselection', 'hangup', 'profile', 'chat', 'recording',
                        'livestreaming', 'etherpad', 'sharedvideo', 'settings', 'raisehand',
                        'videoquality', 'filmstrip', 'invite', 'feedback', 'stats', 'shortcuts',
                        'tileview', 'videobackgroundblur', 'download', 'help', 'mute-everyone', 'security'
                    ],
                }
            };
            const api = new JitsiMeetExternalAPI(domain, options);

            // Hide the note once the user successfully joins the meeting
            api.addEventListener('videoConferenceJoined', () => {
                const note = document.getElementById('meeting-note');
                if (note) {
                    note.style.opacity = '0';
                    setTimeout(() => note.style.display = 'none', 500);
                }
            });
        });
    </script>
</x-app-layout>
