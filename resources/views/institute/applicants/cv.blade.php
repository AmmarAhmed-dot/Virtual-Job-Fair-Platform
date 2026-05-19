<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center no-print-flex">
            <div class="flex items-center space-x-4">
                <a href="{{ url()->previous() }}" class="text-gray-500 hover:text-gray-700 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Curriculum Vitae:') }} {{ $candidate->name }}
                </h2>
            </div>
            <button onclick="window.print()"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-xl text-sm font-bold shadow transition flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                    </path>
                </svg>
                <span>Download PDF</span>
            </button>
        </div>
    </x-slot>

    @php
        // Graceful handling of legacy string data
        $skills = is_array($cv->skills) ? $cv->skills : (empty($cv->skills) ? [] : [['category' => 'Technical Skills', 'list' => $cv->skills]]);

        $experience = [];
        if (is_array($cv->experience)) {
            $experience = $cv->experience;
        } elseif (!empty($cv->experience)) {
            $experience = [
                [
                    'role' => 'Job Experience',
                    'company' => '',
                    'duration' => '',
                    'location' => '',
                    'bullets' => explode("\n", $cv->experience)
                ]
            ];
        }

        $projects = is_array($cv->projects) ? $cv->projects : [];

        $education = [];
        if (is_array($cv->education)) {
            $education = $cv->education;
        } elseif (!empty($cv->education)) {
            $education = [
                [
                    'degree' => 'Education',
                    'institution' => '',
                    'duration' => '',
                    'gpa' => $cv->education
                ]
            ];
        }

        $languages = is_array($cv->languages) ? $cv->languages : [];
    @endphp

    <style>
        /* Print Stylesheet to target only the preview sheet */
        @media print {
            body {
                background: white !important;
                color: black !important;
                font-size: 11pt !important;
            }

            header,
            nav,
            #header-container,
            #sidebar-nav,
            .no-print,
            button,
            a.no-print,
            .no-print-flex {
                display: none !important;
            }

            .py-12 {
                padding-top: 0 !important;
                padding-bottom: 0 !important;
            }

            .max-w-4xl {
                max-width: 100% !important;
                padding: 0 !important;
                margin: 0 !important;
            }

            #cv-preview-sheet {
                position: absolute;
                left: 0;
                top: 0;
                width: 100% !important;
                max-width: 100% !important;
                border: none !important;
                box-shadow: none !important;
                padding: 0 !important;
                margin: 0 !important;
                visibility: visible !important;
            }
        }
    </style>

    <div class="py-12">
        @if(!empty($analysis))
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 mb-8 no-print">
                <div class="p-6 bg-slate-900 text-white rounded-2xl border border-slate-800 shadow-2xl relative overflow-hidden">
                    <!-- Background glow decoration -->
                    <div class="absolute -right-16 -top-16 w-64 h-64 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
                    
                    <!-- Header row -->
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6 relative z-10">
                        <div class="flex items-center space-x-3">
                            <div class="p-2.5 bg-indigo-600/20 rounded-xl text-indigo-400 border border-indigo-500/30">
                                <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-extrabold text-white tracking-tight flex items-center">
                                    AI GitHub Profile Analysis
                                    @if($analysis['has_token'])
                                        <span class="ml-2 text-[10px] bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 px-2 py-0.5 rounded-full font-bold uppercase tracking-wider">Private Access Active</span>
                                    @endif
                                </h3>
                                <a href="https://github.com/{{ $analysis['username'] }}" target="_blank" class="text-xs text-indigo-400 hover:text-indigo-300 font-semibold flex items-center mt-0.5">
                                    <span>@</span><span>{{ $analysis['username'] }}</span>
                                    <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                </a>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3 bg-slate-800/85 px-4 py-2 rounded-xl border border-slate-700/60">
                            <div class="text-right">
                                <p class="text-[10px] text-slate-400 uppercase font-bold tracking-wider">Developer Rank</p>
                                <p class="text-lg font-black text-indigo-400">{{ $analysis['score'] }}/100</p>
                            </div>
                            <div class="w-10 h-10 rounded-full border-4 border-indigo-500/20 flex items-center justify-center relative">
                                <div class="absolute inset-0 rounded-full border-4 border-indigo-500 border-t-transparent animate-spin" style="animation-duration: 3s;"></div>
                                <span class="text-[11px] font-black text-white">{{ $analysis['score'] }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Metrics grid -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6 relative z-10">
                        <div class="bg-slate-800/40 p-4 rounded-xl border border-slate-800 flex flex-col justify-between">
                            <p class="text-[10px] text-slate-400 uppercase font-bold tracking-wider mb-1">Contributions</p>
                            <div class="flex items-baseline space-x-1">
                                <p class="text-2xl font-black text-indigo-400">{{ $analysis['contributions'] ?? $analysis['commits'] ?? 0 }}</p>
                                <span class="text-[9px] text-slate-500">({{ $analysis['commits'] ?? 0 }} c / {{ $analysis['issues_prs'] ?? 0 }} pr)</span>
                            </div>
                        </div>
                        <div class="bg-slate-800/40 p-4 rounded-xl border border-slate-800 flex flex-col justify-between">
                            <p class="text-[10px] text-slate-400 uppercase font-bold tracking-wider mb-1">Repositories</p>
                            <div class="flex items-baseline space-x-1">
                                <p class="text-2xl font-black text-indigo-400">{{ $analysis['repos'] }}</p>
                                @if($analysis['has_token'])
                                    <span class="text-[9px] text-slate-500">({{ $analysis['public_repos'] }} pub / {{ $analysis['private_repos'] }} priv)</span>
                                @else
                                    <span class="text-[10px] text-slate-500">public</span>
                                @endif
                            </div>
                        </div>
                        <div class="bg-slate-800/40 p-4 rounded-xl border border-slate-800 flex flex-col justify-between">
                            <p class="text-[10px] text-slate-400 uppercase font-bold tracking-wider mb-1">Total Stars</p>
                            <div class="flex items-baseline space-x-1">
                                <p class="text-2xl font-black text-yellow-400 flex items-center">
                                    <svg class="w-4.5 h-4.5 mr-1 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                    {{ $analysis['stars'] }}
                                </p>
                                <span class="text-[10px] text-slate-500">stars</span>
                            </div>
                        </div>
                        <div class="bg-slate-800/40 p-4 rounded-xl border border-slate-800 flex flex-col justify-between">
                            <p class="text-[10px] text-slate-400 uppercase font-bold tracking-wider mb-1">Followers</p>
                            <div class="flex items-baseline space-x-1">
                                <p class="text-2xl font-black text-indigo-400">{{ $analysis['followers'] }}</p>
                                <span class="text-[10px] text-slate-500">followers</span>
                            </div>
                        </div>
                    </div>

                    <!-- Languages & Summary -->
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 relative z-10">
                        @if(count($analysis['languages']) > 0)
                            <div class="md:col-span-5">
                                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Top Technologies</h4>
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach($analysis['languages'] as $lang => $count)
                                        <div class="bg-indigo-500/10 border border-indigo-500/20 px-2.5 py-1 rounded-xl flex items-center space-x-1.5 text-xs font-semibold text-indigo-300">
                                            <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span>
                                            <span>{{ $lang }}</span>
                                            <span class="text-[9px] text-slate-500">({{ $count }} repos)</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        <div class="{{ count($analysis['languages']) > 0 ? 'md:col-span-7' : 'md:col-span-12' }}">
                            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">AI Profile Insight</h4>
                            <div class="bg-slate-800/30 p-4 rounded-xl border border-slate-800/60">
                                <p class="text-slate-300 text-xs font-medium leading-relaxed italic">"{{ $analysis['summary'] }}"</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 flex justify-center">
            <div id="cv-preview-sheet"
                class="bg-white w-[210mm] min-h-[297mm] shadow-xl border border-gray-200 p-8 sm:p-12 text-gray-900 font-sans leading-relaxed text-sm select-text">

                <!-- LaTeX Header: Centered Full Name -->
                <div class="text-center mb-4">
                    <h1 class="text-3xl font-bold tracking-tight text-black">{{ $candidate->name }}</h1>
                    <div class="text-xs text-gray-500 mt-1 flex items-center justify-center space-x-1.5">
                        <span class="inline-block w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                        <span>{{ $cv->location ?? 'Not Specified' }}</span>
                    </div>
                </div>

                <!-- Contact Grid -->
                <div class="pb-4 mb-6">
                    <div class="grid grid-cols-2 gap-y-1 gap-x-8 text-xs font-sans text-gray-600 max-w-lg mx-auto">
                        <div class="flex items-center space-x-2">
                            <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                </path>
                            </svg>
                            <span>{{ $cv->phone ?? 'Not Specified' }}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                            <a href="mailto:{{ $candidate->email }}"
                                class="text-blue-600 hover:underline">{{ $candidate->email }}</a>
                        </div>
                        @if($cv->linkedin_url)
                            <div class="flex items-center space-x-2">
                                <svg class="w-3.5 h-3.5 text-gray-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.779-1.75-1.75s.784-1.75 1.75-1.75 1.75.779 1.75 1.75-.784 1.75-1.75 1.75zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                                </svg>
                                <a href="https://{{ $cv->linkedin_url }}" target="_blank"
                                    class="text-blue-600 hover:underline">{{ $cv->linkedin_url }}</a>
                            </div>
                        @endif
                        @if($cv->github_username)
                            <div class="flex items-center space-x-2">
                                <svg class="w-3.5 h-3.5 text-gray-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z" />
                                </svg>
                                <a href="https://github.com/{{ $cv->github_username }}" target="_blank"
                                    class="text-blue-600 hover:underline">github.com/{{ $cv->github_username }}</a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Summary Section -->
                @if($cv->summary)
                    <div class="mb-6">
                        <h2
                            class="text-sm font-bold uppercase tracking-wider text-black border-b border-gray-900 pb-0.5 mb-2">
                            Summary</h2>
                        <p class="text-[10.5pt] text-gray-800 text-justify">{{ $cv->summary }}</p>
                    </div>
                @endif

                <!-- Technical Skills Section -->
                @if(count($skills) > 0)
                    <div class="mb-6">
                        <h2
                            class="text-sm font-bold uppercase tracking-wider text-black border-b border-gray-900 pb-0.5 mb-2">
                            Technical Skills</h2>
                        <table class="w-full text-left border-collapse text-[10pt]">
                            <tbody>
                                @foreach($skills as $skill)
                                    <tr class="align-top">
                                        <td class="font-bold py-1 w-[35%] text-black">{{ $skill['category'] }}:</td>
                                        <td class="py-1 text-gray-800">{{ $skill['list'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                <!-- Experience Section -->
                @if(count($experience) > 0)
                    <div class="mb-6">
                        <h2
                            class="text-sm font-bold uppercase tracking-wider text-black border-b border-gray-900 pb-0.5 mb-2">
                            Experience</h2>
                        @foreach($experience as $exp)
                            <div class="mb-4">
                                <div class="flex justify-between font-bold text-[10.5pt] text-black">
                                    <span>{{ $exp['role'] }}</span>
                                    <span>{{ $exp['duration'] }}</span>
                                </div>
                                <div class="flex justify-between text-xs italic text-gray-600 mb-1">
                                    <span>{{ $exp['company'] }}</span>
                                    <span>{{ $exp['location'] }}</span>
                                </div>
                                <ul class="list-disc pl-5 text-[10pt] text-gray-800 space-y-0.5">
                                    @if(is_array($exp['bullets'] ?? null))
                                        @foreach($exp['bullets'] as $bullet)
                                            <li>{{ $bullet }}</li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Projects Section -->
                @if(count($projects) > 0)
                    <div class="mb-6">
                        <h2
                            class="text-sm font-bold uppercase tracking-wider text-black border-b border-gray-900 pb-0.5 mb-2">
                            Projects</h2>
                        <div class="space-y-3">
                            @foreach($projects as $proj)
                                <div class="text-[10pt]">
                                    <span class="font-bold text-black">{{ $proj['name'] }}</span>
                                    @if(!empty($proj['link']))
                                        <span class="text-gray-400 mx-1">|</span>
                                        <!-- <a href="{{ $proj['link'] }}" target="_blank" class="text-blue-600 hover:underline">{{ $proj['link'] }}</a> -->
                                        <a href="{{ $proj['link'] }}" target="_blank"
                                            class="text-blue-600 hover:underline">(link)</a>
                                    @endif
                                    <p class="text-gray-700 mt-0.5 text-justify">{{ $proj['description'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Education Section -->
                @if(count($education) > 0)
                    <div class="mb-6">
                        <h2
                            class="text-sm font-bold uppercase tracking-wider text-black border-b border-gray-900 pb-0.5 mb-2">
                            Education</h2>
                        @foreach($education as $edu)
                            <div class="mb-3 text-[10pt]">
                                <div class="flex justify-between font-bold text-black">
                                    <span>{{ $edu['degree'] }}</span>
                                    <span>{{ $edu['duration'] }}</span>
                                </div>
                                <div class="flex justify-between text-xs italic text-gray-600">
                                    <span>{{ $edu['institution'] }}</span>
                                    <span>{{ $edu['gpa'] }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Languages Section -->
                @if(count($languages) > 0)
                    <div class="mb-6">
                        <h2
                            class="text-sm font-bold uppercase tracking-wider text-black border-b border-gray-900 pb-0.5 mb-2">
                            Languages</h2>
                        <div class="grid grid-cols-2 gap-2 text-[10pt] text-gray-800">
                            @foreach($languages as $lang)
                                <div class="flex space-x-2">
                                    <strong class="text-black">{{ $lang['name'] }}:</strong>
                                    <span>{{ $lang['proficiency'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>

        </div>
    </div>
</x-app-layout>