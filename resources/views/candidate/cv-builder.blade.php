<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-gray-700 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('CV Builder') }}
                </h2>
            </div>
            <button type="button" onclick="window.print()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-xl text-sm font-bold shadow transition flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                <span>Download PDF</span>
            </button>
        </div>
    </x-slot>

    @php
        // Technical Skills
        $skills = $cv->skills;
        if (!is_array($skills)) {
            $skills = empty($skills) ? [
                ['category' => 'Languages & Frameworks', 'list' => 'React.js, Next.js, Node.js, Electron.js, PHP, Laravel, Flutter'],
                ['category' => 'Databases', 'list' => 'MySQL, PostgreSQL, MongoDB, Firebase'],
                ['category' => 'Infrastructure & Tools', 'list' => 'GitHub Actions, Docker, SVN, App Store Connect'],
            ] : [['category' => 'Technical Skills', 'list' => $skills]];
        }

        // Experience
        $experience = $cv->experience;
        if (!is_array($experience)) {
            $experience = empty($experience) ? [
                [
                    'duration' => 'May 2025 -- Present',
                    'role' => 'Senior Software Engineer',
                    'company' => 'Webscare',
                    'location' => 'Sargodha, Pakistan',
                    'bullets' => [
                        'Engineered high-traffic Next.js platforms using headless architectures and Apollo Client.',
                        'Optimized React performance via memoization to handle data-heavy admin dashboards.',
                    ]
                ]
            ] : [
                [
                    'duration' => '',
                    'role' => 'Job Experience',
                    'company' => '',
                    'location' => '',
                    'bullets' => explode("\n", $experience)
                ]
            ];
        }

        // Projects
        $projects = $cv->projects;
        if (!is_array($projects)) {
            $projects = empty($projects) ? [
                [
                    'name' => 'GDPR Compliance Hub',
                    'description' => 'Architected an automated scanner and central hub for GDPR-compliant software products and security tools.',
                    'link' => 'https://dashboard.gosign.de/'
                ]
            ] : [];
        }

        // Education
        $education = $cv->education;
        if (!is_array($education)) {
            $education = empty($education) ? [
                [
                    'duration' => '2020 -- 2024',
                    'degree' => 'Bachelor of Science in Information Technology',
                    'institution' => 'University of Sargodha',
                    'gpa' => 'CGPA: 2.08'
                ]
            ] : [
                [
                    'duration' => '',
                    'degree' => 'Education',
                    'institution' => '',
                    'gpa' => $education
                ]
            ];
        }

        // Languages
        $languages = $cv->languages;
        if (!is_array($languages)) {
            $languages = empty($languages) ? [
                [
                    'name' => 'English',
                    'proficiency' => 'IELTS 6.5'
                ],
                [
                    'name' => 'Urdu',
                    'proficiency' => 'Native'
                ]
            ] : [];
        }

        $cvData = [
            'summary' => $cv->summary ?? 'Senior Software Engineer specializing in privacy-first, scalable web and mobile applications.',
            'phone' => $cv->phone ?? '+92 310 1714636',
            'location' => $cv->location ?? 'Sargodha, Pakistan',
            'linkedin_url' => $cv->linkedin_url ?? 'linkedin.com/in/ammar-ahmed-dot',
            'github_username' => $cv->github_username ?? 'AmmarAhmed-dot',
            'skills' => $skills,
            'experience' => $experience,
            'projects' => $projects,
            'education' => $education,
            'languages' => $languages
        ];
    @endphp

    <style>
        /* Print Stylesheet to target only the preview sheet */
        @media print {
            body {
                background: white !important;
                color: black !important;
                font-size: 11pt !important;
            }
            /* Hide everything else */
            header, nav, #header-container, #sidebar-nav, .no-print, button, a.no-print {
                display: none !important;
            }
            .py-12 {
                padding-top: 0 !important;
                padding-bottom: 0 !important;
            }
            .max-w-7xl {
                max-width: 100% !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            /* Unhide only the CV A4 sheet */
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

    <div class="py-12 no-print-container" x-data="{
        cv: @js($cvData),
        activeTab: 'personal',
        addSkill() { this.cv.skills.push({ category: '', list: '' }) },
        removeSkill(index) { this.cv.skills.splice(index, 1) },
        addExperience() { this.cv.experience.push({ duration: '', role: '', company: '', location: '', bullets: [''] }) },
        removeExperience(index) { this.cv.experience.splice(index, 1) },
        addBullet(expIndex) { this.cv.experience[expIndex].bullets.push('') },
        removeBullet(expIndex, bulletIndex) { this.cv.experience[expIndex].bullets.splice(bulletIndex, 1) },
        addProject() { this.cv.projects.push({ name: '', description: '', link: '' }) },
        removeProject(index) { this.cv.projects.splice(index, 1) },
        addEducation() { this.cv.education.push({ duration: '', degree: '', institution: '', gpa: '' }) },
        removeEducation(index) { this.cv.education.splice(index, 1) },
        addLanguage() { this.cv.languages.push({ name: '', proficiency: '' }) },
        removeLanguage(index) { this.cv.languages.splice(index, 1) }
    }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 no-print">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- LEFT SIDE: FORM EDITOR (no-print) -->
                <div class="lg:col-span-5 space-y-6 no-print">
                    <form action="{{ route('candidate.cv-store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Form Card Container -->
                        <div class="bg-white rounded-2xl border border-gray-200/80 shadow-sm overflow-hidden">
                            <!-- Tab Headers -->
                            <div class="flex border-b overflow-x-auto bg-gray-50/50">
                                <button type="button" @click="activeTab = 'personal'" :class="activeTab === 'personal' ? 'border-indigo-600 text-indigo-600 bg-white' : 'border-transparent text-gray-500 hover:text-gray-700'" class="whitespace-nowrap px-4 py-3 border-b-2 text-xs font-bold transition">Contact</button>
                                <button type="button" @click="activeTab = 'skills'" :class="activeTab === 'skills' ? 'border-indigo-600 text-indigo-600 bg-white' : 'border-transparent text-gray-500 hover:text-gray-700'" class="whitespace-nowrap px-4 py-3 border-b-2 text-xs font-bold transition">Skills</button>
                                <button type="button" @click="activeTab = 'experience'" :class="activeTab === 'experience' ? 'border-indigo-600 text-indigo-600 bg-white' : 'border-transparent text-gray-500 hover:text-gray-700'" class="whitespace-nowrap px-4 py-3 border-b-2 text-xs font-bold transition">Experience</button>
                                <button type="button" @click="activeTab = 'projects'" :class="activeTab === 'projects' ? 'border-indigo-600 text-indigo-600 bg-white' : 'border-transparent text-gray-500 hover:text-gray-700'" class="whitespace-nowrap px-4 py-3 border-b-2 text-xs font-bold transition">Projects</button>
                                <button type="button" @click="activeTab = 'education'" :class="activeTab === 'education' ? 'border-indigo-600 text-indigo-600 bg-white' : 'border-transparent text-gray-500 hover:text-gray-700'" class="whitespace-nowrap px-4 py-3 border-b-2 text-xs font-bold transition">Education</button>
                                <button type="button" @click="activeTab = 'languages'" :class="activeTab === 'languages' ? 'border-indigo-600 text-indigo-600 bg-white' : 'border-transparent text-gray-500 hover:text-gray-700'" class="whitespace-nowrap px-4 py-3 border-b-2 text-xs font-bold transition">Languages</button>
                            </div>

                            <div class="p-6">
                                <!-- Personal & Summary Info -->
                                <div x-show="activeTab === 'personal'" class="space-y-4">
                                    <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider mb-2">Personal Information</h3>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Phone Number</label>
                                        <input type="text" name="phone" x-model="cv.phone" class="w-full border-gray-300 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-sm shadow-sm">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Location</label>
                                        <input type="text" name="location" x-model="cv.location" class="w-full border-gray-300 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-sm shadow-sm" placeholder="e.g. Lahore, Pakistan">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">LinkedIn Username/Handle</label>
                                        <input type="text" name="linkedin_url" x-model="cv.linkedin_url" class="w-full border-gray-300 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-sm shadow-sm" placeholder="linkedin.com/in/username">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">GitHub Username</label>
                                        <input type="text" name="github_username" x-model="cv.github_username" class="w-full border-gray-300 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-sm shadow-sm" placeholder="username">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Professional Summary</label>
                                        <textarea name="summary" x-model="cv.summary" class="w-full border-gray-300 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-sm shadow-sm" rows="5" required></textarea>
                                    </div>
                                </div>

                                <!-- Technical Skills -->
                                <div x-show="activeTab === 'skills'" class="space-y-4">
                                    <div class="flex justify-between items-center mb-2">
                                        <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider">Skills Categories</h3>
                                        <button type="button" @click="addSkill()" class="text-xs bg-indigo-50 text-indigo-600 px-3 py-1.5 rounded-lg font-bold hover:bg-indigo-100 transition">+ Add Category</button>
                                    </div>
                                    <template x-for="(skill, index) in cv.skills" :key="index">
                                        <div class="p-4 bg-gray-50/50 rounded-xl border relative mb-4">
                                            <button type="button" @click="removeSkill(index)" class="absolute top-2 right-2 text-xs text-red-500 hover:underline">Remove</button>
                                            <div class="space-y-2">
                                                <div>
                                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Category Title</label>
                                                    <input type="text" :name="`skills[${index}][category]`" x-model="skill.category" class="w-full border-gray-300 rounded-lg text-xs py-1.5 shadow-sm" placeholder="e.g. Languages & Frameworks">
                                                </div>
                                                <div>
                                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Skills List (comma separated)</label>
                                                    <input type="text" :name="`skills[${index}][list]`" x-model="skill.list" class="w-full border-gray-300 rounded-lg text-xs py-1.5 shadow-sm" placeholder="e.g. React.js, Next.js, PHP">
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>

                                <!-- Experience -->
                                <div x-show="activeTab === 'experience'" class="space-y-4">
                                    <div class="flex justify-between items-center mb-2">
                                        <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider">Work Experience</h3>
                                        <button type="button" @click="addExperience()" class="text-xs bg-indigo-50 text-indigo-600 px-3 py-1.5 rounded-lg font-bold hover:bg-indigo-100 transition">+ Add Position</button>
                                    </div>
                                    <template x-for="(exp, expIdx) in cv.experience" :key="expIdx">
                                        <div class="p-4 bg-gray-50/50 rounded-xl border relative mb-4">
                                            <button type="button" @click="removeExperience(expIdx)" class="absolute top-2 right-2 text-xs text-red-500 hover:underline">Remove</button>
                                            <div class="grid grid-cols-2 gap-2 mb-2">
                                                <div>
                                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-0.5">Role/Title</label>
                                                    <input type="text" :name="`experience[${expIdx}][role]`" x-model="exp.role" class="w-full border-gray-300 rounded-lg text-xs py-1.5" placeholder="e.g. Software Engineer">
                                                </div>
                                                <div>
                                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-0.5">Company</label>
                                                    <input type="text" :name="`experience[${expIdx}][company]`" x-model="exp.company" class="w-full border-gray-300 rounded-lg text-xs py-1.5" placeholder="e.g. Webscare">
                                                </div>
                                            </div>
                                            <div class="grid grid-cols-2 gap-2 mb-2">
                                                <div>
                                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-0.5">Duration</label>
                                                    <input type="text" :name="`experience[${expIdx}][duration]`" x-model="exp.duration" class="w-full border-gray-300 rounded-lg text-xs py-1.5" placeholder="e.g. May 2025 -- Present">
                                                </div>
                                                <div>
                                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-0.5">Location</label>
                                                    <input type="text" :name="`experience[${expIdx}][location]`" x-model="exp.location" class="w-full border-gray-300 rounded-lg text-xs py-1.5" placeholder="e.g. Lahore, Pakistan">
                                                </div>
                                            </div>
                                            <!-- Bullet Points -->
                                            <div class="mt-3">
                                                <div class="flex justify-between items-center mb-1">
                                                    <label class="block text-[10px] font-bold text-gray-500 uppercase">Key Achievements</label>
                                                    <button type="button" @click="addBullet(expIdx)" class="text-[10px] text-indigo-600 hover:underline">+ Add Point</button>
                                                </div>
                                                <template x-for="(bullet, bulletIdx) in exp.bullets" :key="bulletIdx">
                                                    <div class="flex items-center space-x-1.5 mb-1.5">
                                                        <input type="text" :name="`experience[${expIdx}][bullets][${bulletIdx}]`" x-model="exp.bullets[bulletIdx]" class="w-full border-gray-300 rounded-lg text-xs py-1 shadow-sm" placeholder="e.g. Developed Next.js platform...">
                                                        <button type="button" @click="removeBullet(expIdx, bulletIdx)" class="text-red-500 hover:text-red-700 text-xs">×</button>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                    </template>
                                </div>

                                <!-- Projects -->
                                <div x-show="activeTab === 'projects'" class="space-y-4">
                                    <div class="flex justify-between items-center mb-2">
                                        <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider">Projects</h3>
                                        <button type="button" @click="addProject()" class="text-xs bg-indigo-50 text-indigo-600 px-3 py-1.5 rounded-lg font-bold hover:bg-indigo-100 transition">+ Add Project</button>
                                    </div>
                                    <template x-for="(proj, index) in cv.projects" :key="index">
                                        <div class="p-4 bg-gray-50/50 rounded-xl border relative mb-4">
                                            <button type="button" @click="removeProject(index)" class="absolute top-2 right-2 text-xs text-red-500 hover:underline">Remove</button>
                                            <div class="space-y-2">
                                                <div>
                                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-0.5">Project Name</label>
                                                    <input type="text" :name="`projects[${index}][name]`" x-model="proj.name" class="w-full border-gray-300 rounded-lg text-xs py-1.5" placeholder="e.g. GDPR Compliance Hub">
                                                </div>
                                                <div>
                                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-0.5">Project Link/URL</label>
                                                    <input type="text" :name="`projects[${index}][link]`" x-model="proj.link" class="w-full border-gray-300 rounded-lg text-xs py-1.5" placeholder="e.g. https://github.com/...">
                                                </div>
                                                <div>
                                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-0.5">Description</label>
                                                    <textarea :name="`projects[${index}][description]`" x-model="proj.description" class="w-full border-gray-300 rounded-lg text-xs py-1.5 shadow-sm" rows="3" placeholder="Explain the project achievements..."></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>

                                <!-- Education -->
                                <div x-show="activeTab === 'education'" class="space-y-4">
                                    <div class="flex justify-between items-center mb-2">
                                        <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider">Education History</h3>
                                        <button type="button" @click="addEducation()" class="text-xs bg-indigo-50 text-indigo-600 px-3 py-1.5 rounded-lg font-bold hover:bg-indigo-100 transition">+ Add School</button>
                                    </div>
                                    <template x-for="(edu, index) in cv.education" :key="index">
                                        <div class="p-4 bg-gray-50/50 rounded-xl border relative mb-4">
                                            <button type="button" @click="removeEducation(index)" class="absolute top-2 right-2 text-xs text-red-500 hover:underline">Remove</button>
                                            <div class="grid grid-cols-2 gap-2 mb-2">
                                                <div>
                                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-0.5">Degree/Major</label>
                                                    <input type="text" :name="`education[${index}][degree]`" x-model="edu.degree" class="w-full border-gray-300 rounded-lg text-xs py-1.5" placeholder="e.g. Bachelor of Science in IT">
                                                </div>
                                                <div>
                                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-0.5">School/University</label>
                                                    <input type="text" :name="`education[${index}][institution]`" x-model="edu.institution" class="w-full border-gray-300 rounded-lg text-xs py-1.5" placeholder="e.g. University of Sargodha">
                                                </div>
                                            </div>
                                            <div class="grid grid-cols-2 gap-2">
                                                <div>
                                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-0.5">Duration</label>
                                                    <input type="text" :name="`education[${index}][duration]`" x-model="edu.duration" class="w-full border-gray-300 rounded-lg text-xs py-1.5" placeholder="e.g. 2020 -- 2024">
                                                </div>
                                                <div>
                                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-0.5">Details (GPA/Honors)</label>
                                                    <input type="text" :name="`education[${index}][gpa]`" x-model="edu.gpa" class="w-full border-gray-300 rounded-lg text-xs py-1.5" placeholder="e.g. CGPA: 2.08">
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>

                                <!-- Languages -->
                                <div x-show="activeTab === 'languages'" class="space-y-4">
                                    <div class="flex justify-between items-center mb-2">
                                        <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider">Languages</h3>
                                        <button type="button" @click="addLanguage()" class="text-xs bg-indigo-50 text-indigo-600 px-3 py-1.5 rounded-lg font-bold hover:bg-indigo-100 transition">+ Add Language</button>
                                    </div>
                                    <template x-for="(lang, index) in cv.languages" :key="index">
                                        <div class="p-4 bg-gray-50/50 rounded-xl border relative mb-4">
                                            <button type="button" @click="removeLanguage(index)" class="absolute top-2 right-2 text-xs text-red-500 hover:underline">Remove</button>
                                            <div class="grid grid-cols-2 gap-2">
                                                <div>
                                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-0.5">Language</label>
                                                    <input type="text" :name="`languages[${index}][name]`" x-model="lang.name" class="w-full border-gray-300 rounded-lg text-xs py-1.5" placeholder="e.g. English">
                                                </div>
                                                <div>
                                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-0.5">Proficiency</label>
                                                    <input type="text" :name="`languages[${index}][proficiency]`" x-model="lang.proficiency" class="w-full border-gray-300 rounded-lg text-xs py-1.5" placeholder="e.g. IELTS 6.5 (B2)">
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3.5 rounded-xl font-bold transition shadow-lg shadow-indigo-100 flex items-center justify-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                            <span>Save CV Data</span>
                        </button>
                    </form>
                </div>

                <!-- RIGHT SIDE: LIVE LATEX PREVIEW (A4 Mock sheet) -->
                <div class="lg:col-span-7 bg-gray-100/50 p-4 sm:p-8 rounded-2xl border border-gray-200/60 shadow-inner no-print-container flex justify-center">
                    <div id="cv-preview-sheet" class="bg-white w-[210mm] min-h-[297mm] shadow-2xl border border-gray-200/80 p-8 sm:p-12 text-gray-900 font-serif leading-relaxed text-sm select-text">
                        
                        <!-- LaTeX Header: Centered Full Name -->
                        <div class="text-center mb-4">
                            <h1 class="text-3xl font-bold tracking-tight text-black" x-text="`{{ Auth::user()->name }}`"></h1>
                            <div class="text-xs text-gray-500 mt-1 flex items-center justify-center space-x-1.5">
                                <span class="inline-block w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                <span x-text="cv.location"></span>
                            </div>
                        </div>

                        <!-- Contact Grid -->
                        <div class="border-b pb-4 mb-6">
                            <div class="grid grid-cols-2 gap-y-1 gap-x-8 text-xs font-sans text-gray-600 max-w-lg mx-auto">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                    <span x-text="cv.phone"></span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    <a :href="`mailto:{{ Auth::user()->email }}`" class="text-blue-600 hover:underline" x-text="`{{ Auth::user()->email }}`"></a>
                                </div>
                                <div class="flex items-center space-x-2" x-show="cv.linkedin_url">
                                    <svg class="w-3.5 h-3.5 text-gray-500" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.779-1.75-1.75s.784-1.75 1.75-1.75 1.75.779 1.75 1.75-.784 1.75-1.75 1.75zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                                    <a :href="'https://' + cv.linkedin_url" target="_blank" class="text-blue-600 hover:underline" x-text="cv.linkedin_url"></a>
                                </div>
                                <div class="flex items-center space-x-2" x-show="cv.github_username">
                                    <svg class="w-3.5 h-3.5 text-gray-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                                    <a :href="'https://github.com/' + cv.github_username" target="_blank" class="text-blue-600 hover:underline" x-text="'github.com/' + cv.github_username"></a>
                                </div>
                            </div>
                        </div>

                        <!-- Summary Section -->
                        <div class="mb-6">
                            <h2 class="text-sm font-bold uppercase tracking-wider text-black border-b border-gray-900 pb-0.5 mb-2">Summary</h2>
                            <p class="text-[10.5pt] text-gray-800 text-justify" x-text="cv.summary"></p>
                        </div>

                        <!-- Technical Skills Section -->
                        <div class="mb-6" x-show="cv.skills.length > 0">
                            <h2 class="text-sm font-bold uppercase tracking-wider text-black border-b border-gray-900 pb-0.5 mb-2">Technical Skills</h2>
                            <table class="w-full text-left border-collapse text-[10pt]">
                                <tbody>
                                    <template x-for="skill in cv.skills">
                                        <tr class="align-top">
                                            <td class="font-bold py-1 w-[35%] text-black" x-text="skill.category + ':'"></td>
                                            <td class="py-1 text-gray-800" x-text="skill.list"></td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>

                        <!-- Experience Section -->
                        <div class="mb-6" x-show="cv.experience.length > 0">
                            <h2 class="text-sm font-bold uppercase tracking-wider text-black border-b border-gray-900 pb-0.5 mb-2">Experience</h2>
                            <template x-for="exp in cv.experience">
                                <div class="mb-4">
                                    <div class="flex justify-between font-bold text-[10.5pt] text-black">
                                        <span x-text="exp.role"></span>
                                        <span x-text="exp.duration"></span>
                                    </div>
                                    <div class="flex justify-between text-xs italic text-gray-600 mb-1">
                                        <span x-text="exp.company"></span>
                                        <span x-text="exp.location"></span>
                                    </div>
                                    <ul class="list-disc pl-5 text-[10pt] text-gray-800 space-y-0.5">
                                        <template x-for="bullet in exp.bullets">
                                            <li x-text="bullet"></li>
                                        </template>
                                    </ul>
                                </div>
                            </template>
                        </div>

                        <!-- Projects Section -->
                        <div class="mb-6" x-show="cv.projects.length > 0">
                            <h2 class="text-sm font-bold uppercase tracking-wider text-black border-b border-gray-900 pb-0.5 mb-2">Projects</h2>
                            <div class="space-y-3">
                                <template x-for="proj in cv.projects">
                                    <div class="text-[10pt]">
                                        <span class="font-bold text-black" x-text="proj.name"></span>
                                        <span class="text-gray-400 mx-1">|</span>
                                        <a :href="proj.link" target="_blank" class="text-blue-600 hover:underline" x-text="proj.link"></a>
                                        <p class="text-gray-700 mt-0.5 text-justify" x-text="proj.description"></p>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- Education Section -->
                        <div class="mb-6" x-show="cv.education.length > 0">
                            <h2 class="text-sm font-bold uppercase tracking-wider text-black border-b border-gray-900 pb-0.5 mb-2">Education</h2>
                            <template x-for="edu in cv.education">
                                <div class="mb-3 text-[10pt]">
                                    <div class="flex justify-between font-bold text-black">
                                        <span x-text="edu.degree"></span>
                                        <span x-text="edu.duration"></span>
                                    </div>
                                    <div class="flex justify-between text-xs italic text-gray-600">
                                        <span x-text="edu.institution"></span>
                                        <span x-text="edu.gpa"></span>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <!-- Languages Section -->
                        <div class="mb-6" x-show="cv.languages.length > 0">
                            <h2 class="text-sm font-bold uppercase tracking-wider text-black border-b border-gray-900 pb-0.5 mb-2">Languages</h2>
                            <div class="grid grid-cols-2 gap-2 text-[10pt] text-gray-800">
                                <template x-for="lang in cv.languages">
                                    <div class="flex space-x-2">
                                        <strong class="text-black" x-text="lang.name + ':'"></strong>
                                        <span x-text="lang.proficiency"></span>
                                    </div>
                                </template>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
