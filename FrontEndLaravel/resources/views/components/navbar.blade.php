<header class="sticky top-0 z-40 mb-3 sm:mb-4">

    <div class="h-16 sm:h-20 px-3 sm:px-6 flex items-center justify-between rounded-2xl sm:rounded-[28px] border border-slate-200/80 bg-white/85 backdrop-blur-xl shadow-[0_12px_30px_rgba(15,23,42,0.05)]">

        <!-- LEFT SIDE -->
        <div class="flex items-center gap-2 sm:gap-4 min-w-0 flex-1">

            <!-- Sidebar Toggle -->
            <button
                id="sidebarToggle"
                class="p-2.5 sm:p-3 rounded-2xl bg-slate-100 text-slate-600 hover:bg-slate-200 transition shadow-sm shrink-0">

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-4 h-4 sm:w-5 sm:h-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16"
                    />

                </svg>

            </button>


            <!-- LOGO + BRAND -->
            <div class="flex items-center gap-2 sm:gap-3 min-w-0">

                <!-- Logo -->
                <div class="h-14 w-14 sm:h-20 sm:w-24 flex items-center justify-center shrink-0">

                    <img
                        src="{{ asset('images/karsa-nirmala-logo.png') }}"
                        alt="Karsa Nirmala logo"
                        class="h-14 w-14 sm:h-20 sm:w-24 object-contain drop-shadow-sm"
                    >

                </div>


                <!-- Brand -->
                <div class="leading-none min-w-0">

                    <h1 class="font-black text-sm sm:text-base md:text-lg lg:text-[1.6rem] tracking-tight text-slate-800 truncate">
                        Karsa Nirmala
                    </h1>

                    <p class="hidden sm:block mt-1 text-xs text-slate-500 truncate">
                        Sistem Cerdas Pengelolaan Sampah
                    </p>

                </div>

            </div>

        </div>


        <!-- RIGHT SIDE -->
        <div class="flex items-center gap-2 sm:gap-4 shrink-0">

            <!-- Notification -->
            <button
                class="relative p-2 sm:p-2.5 rounded-full bg-slate-100 hover:bg-slate-200 transition">

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-4 h-4 sm:w-5 sm:h-5 text-slate-600"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M15 17h5l-1.4-1.4A2 2 0 0118 14.2V11a6 6 0 10-12 0v3.2a2 2 0 01-.6 1.4L4 17h5m6 0a3 3 0 11-6 0m6 0H9"
                    />

                </svg>

                <span
                    class="absolute -top-1 -right-1 w-2.5 h-2.5 sm:w-3 sm:h-3 bg-red-500 rounded-full border-2 border-white">
                </span>

            </button>


            <!-- User Profile -->
            <div class="hidden sm:flex items-center gap-2 sm:gap-3 rounded-full border border-slate-200 bg-slate-50/80 px-2 sm:px-3 py-2 shadow-sm">

                <img
                    src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'User') }}&background=E2F8D5&color=14532D"
                    alt="User Avatar"
                    class="w-8 h-8 sm:w-11 sm:h-11 rounded-full border-2 border-white shadow-sm"
                >

                <div class="hidden md:block">

                    <p class="font-bold text-slate-800 leading-tight text-sm">
                        {{ Auth::user()->name ?? 'Guest' }}
                    </p>

                    <p class="text-xs text-slate-500">
                        Member
                    </p>

                </div>

            </div>

            <!-- Mobile User Avatar Only -->
            <div class="sm:hidden">
                <img
                    src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'User') }}&background=E2F8D5&color=14532D"
                    alt="User Avatar"
                    class="w-8 h-8 rounded-full border-2 border-white shadow-sm"
                >
            </div>

        </div>

    </div>
</header>