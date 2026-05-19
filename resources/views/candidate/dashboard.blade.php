<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Candidate Dashboard') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div class="bg-white p-6 rounded-lg shadow-sm border">
                    <h3 class="font-bold text-lg mb-2">My Applications</h3>
                    <p class="text-3xl font-extrabold text-indigo-600">{{ $stats['my_applications'] }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm border">
                    <h3 class="font-bold text-lg mb-2">Jobs Applied</h3>
                    <p class="text-3xl font-extrabold text-green-600">{{ $stats['my_applications'] }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm border">
                    <h3 class="font-bold text-lg mb-2">Profile Completeness</h3>
                    <p class="text-3xl font-extrabold text-orange-600">{{ $stats['profile_completeness'] }}%</p>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($analysis)
                        <div class="mb-8 p-6 bg-slate-900 text-white rounded-2xl border border-slate-800 shadow-2xl relative overflow-hidden">
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
                                            GitHub Profile Analysis
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
                                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Profile Insight</h4>
                                    <div class="bg-slate-800/30 p-4 rounded-xl border border-slate-800/60">
                                        <p class="text-slate-300 text-xs font-medium leading-relaxed italic">"{{ $analysis['summary'] }}"</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <h3 class="font-bold mb-4">Quick Links</h3>
                    <div class="flex space-x-4">
                        <a href="{{ route('jobs.index') }}" class="bg-indigo-600 text-white px-4 py-2 rounded">Browse Jobs</a>
                        <a href="{{ route('candidate.cv-builder') }}" class="bg-indigo-600 text-white px-4 py-2 rounded">Build My CV</a>
                        <a href="{{ route('profile.edit') }}" class="bg-indigo-600 text-white px-4 py-2 rounded">My Profile</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
