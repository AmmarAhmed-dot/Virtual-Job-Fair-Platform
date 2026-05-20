<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>VJFP - Virtual Job Fair Platform</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=outfit:400,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }

        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
        }

        .gradient-text {
            background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>

<body class="antialiased bg-gray-50 text-gray-900">
    <!-- Navigation -->
    <nav class="fixed w-full z-50 glass border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="text-2xl font-extrabold gradient-text tracking-tight">VJFP</a>
                </div>
                <div class="hidden md:flex items-center space-x-8 font-semibold text-gray-600">
                    @auth
                        @if(Auth::user()->role === 'institute')
                            <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 transition">For Employers</a>
                        @else
                            <a href="{{ route('jobs.index') }}" class="hover:text-indigo-600 transition">Browse Jobs</a>
                        @endif
                    @else
                        <a href="{{ route('register', ['role' => 'institute']) }}" class="hover:text-indigo-600 transition">For Employers</a>
                        <a href="{{ route('jobs.index') }}" class="hover:text-indigo-600 transition">For Candidates</a>
                    @endauth
                    <a href="{{ route('events.index') }}" class="hover:text-indigo-600 transition">Events</a>
                </div>
                <div class="flex items-center space-x-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}"
                                class="font-bold text-gray-600 hover:text-indigo-600">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="font-bold text-gray-600 hover:text-indigo-600">Log in</a>
                            <a href="{{ route('register') }}"
                                class="bg-indigo-600 text-white px-6 py-2.5 rounded-full font-bold shadow-lg shadow-indigo-200 hover:scale-105 transition transform">Get
                                Started</a>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="relative pt-40 pb-20 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <h1 class="text-6xl md:text-8xl font-extrabold tracking-tight mb-8 leading-tight">
                Your Future Starts <br> <span class="gradient-text">Virtually Here.</span>
            </h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto mb-12 font-medium">
                Connect with global employers, attend virtual fairs, and build your career without geographical
                boundaries. The next-generation recruitment platform for universities and students.
            </p>
            <div class="flex flex-col md:flex-row justify-center items-center space-y-4 md:space-y-0 md:space-x-6">
                @auth
                    @if(Auth::user()->role === 'candidate')
                        <a href="{{ route('jobs.index') }}"
                            class="bg-indigo-600 text-white px-10 py-4 rounded-full text-lg font-bold shadow-xl shadow-indigo-100 hover:bg-indigo-700 transition">Browse
                            Available Jobs</a>
                    @else
                        <a href="{{ route('dashboard') }}"
                            class="bg-indigo-600 text-white px-10 py-4 rounded-full text-lg font-bold shadow-xl shadow-indigo-100 hover:bg-indigo-700 transition">Go
                            to Dashboard</a>
                    @endif
                @else
                    <a href="{{ route('register', ['role' => 'candidate']) }}"
                        class="bg-indigo-600 text-white px-10 py-4 rounded-full text-lg font-bold shadow-xl shadow-indigo-100 hover:bg-indigo-700 transition">Find
                        My Dream Job</a>
                @endauth

                @auth
                    @if(Auth::user()->role === 'institute')
                        <a href="{{ route('institute.jobs.create') }}"
                            class="border-2 border-gray-200 text-gray-700 px-10 py-4 rounded-full text-lg font-bold hover:bg-white transition">Post a Job</a>
                    @endif
                @else
                    <a href="{{ route('register', ['role' => 'institute']) }}"
                        class="border-2 border-gray-200 text-gray-700 px-10 py-4 rounded-full text-lg font-bold hover:bg-white transition">Hire Talent</a>
                @endauth
            </div>
        </div>

        <!-- Background Elements -->
        <div
            class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-indigo-100 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-pulse">
        </div>
        <div
            class="absolute bottom-0 left-0 -ml-20 -mb-20 w-96 h-96 bg-purple-100 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-pulse delay-700">
        </div>
    </header>

    <!-- Features Section -->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20">
                <h2 class="text-4xl font-bold mb-4">Complete Virtual Ecosystem</h2>
                <p class="text-gray-500 max-w-xl mx-auto font-medium">Everything you need to succeed in the modern job
                    market, all in one place.</p>
            </div>
            <!-- <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8"> -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <div
                    class="p-8 rounded-3xl bg-gray-50 hover:bg-indigo-50 transition border border-transparent hover:border-indigo-100">
                    <div
                        class="w-14 h-14 bg-indigo-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-indigo-100">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">GitHub Analysis</h3>
                    <p class="text-gray-600 leading-relaxed">Instantly analyze candidates' lifetime contributions,
                        repositories, top languages, and developer stats with automated profiling insights.</p>
                </div>
                <div
                    class="p-8 rounded-3xl bg-gray-50 hover:bg-purple-50 transition border border-transparent hover:border-purple-100">
                    <div
                        class="w-14 h-14 bg-purple-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-purple-100">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">CV Builder</h3>
                    <p class="text-gray-600 leading-relaxed">Craft a professional CV using structured templates designed
                        to compile beautifully for recruiters.</p>
                </div>
                <!-- <div
                    class="p-8 rounded-3xl bg-gray-50 hover:bg-blue-50 transition border border-transparent hover:border-blue-100">
                    <div
                        class="w-14 h-14 bg-blue-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-blue-100">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Virtual Events</h3>
                    <p class="text-gray-600 leading-relaxed">Host and participate in large-scale career fairs, webinars,
                        and networking events from anywhere.</p>
                </div> -->
                <div
                    class="p-8 rounded-3xl bg-gray-50 hover:bg-green-50 transition border border-transparent hover:border-green-100">
                    <div
                        class="w-14 h-14 bg-green-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-green-100">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Real-Time Interviews</h3>
                    <p class="text-gray-600 leading-relaxed">Schedule and conduct built-in virtual interviews seamlessly using dynamically generated secure video rooms.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-12 border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-gray-400 font-semibold">&copy; {{ date('Y') }} VJFP - Virtual Job Fair Platform. Built for
                Excellence.</p>
        </div>
    </footer>
</body>

</html>