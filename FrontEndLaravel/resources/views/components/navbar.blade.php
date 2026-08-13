<header class="sticky top-0 z-40 mb-4">

    <div class="h-20 px-4 sm:px-6 flex items-center justify-between rounded-[28px] border border-slate-200/80 bg-white/85 backdrop-blur-xl shadow-[0_12px_30px_rgba(15,23,42,0.05)]">

        <div class="flex items-center gap-4">

            <button id="sidebarToggle" class="p-3 rounded-2xl bg-slate-100 text-slate-600 hover:bg-slate-200 transition shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <div class="flex items-center gap-3">
                <img src="{{ asset('images/karsa-nirmala-logo.svg') }}" alt="Karsa Nirmala logo" class="h-10 w-10 object-contain">
                <div>
                    <h1 class="font-black text-2xl text-slate-800">
                        Karsa Nirmala
                    </h1>

                    <p class="text-sm text-slate-500">
                        Waste Identification and Sustainability Education
                    </p>
                </div>
            </div>

        </div>

        <div class="flex items-center gap-4">

            <button class="relative p-2.5 rounded-full bg-slate-100 hover:bg-slate-200 transition">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-5 h-5 text-slate-600"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M15 17h5l-1.4-1.4A2 2 0 0118 14.2V11a6 6 0 10-12 0v3.2a2 2 0 01-.6 1.4L4 17h5m6 0a3 3 0 11-6 0m6 0H9"/>
                </svg>

                <span class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full border-2 border-white"></span>
            </button>

            <div class="flex items-center gap-3 rounded-full border border-slate-200 bg-slate-50/80 px-3 py-2 shadow-sm">

                <img
                    src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'User') }}&background=E2F8D5&color=14532D"
                    class="w-11 h-11 rounded-full border-2 border-white shadow-sm">

                <div>
                    <p class="font-bold text-slate-800 leading-tight">
                        {{ Auth::user()->name ?? 'Guest' }}
                    </p>

                    <p class="text-xs text-slate-500">
                        Member
                    </p>
                </div>

            </div>

        </div>

    </div>

</header>
