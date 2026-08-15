<aside
    class="w-full max-w-xs lg:w-72 lg:flex-none
           bg-white/90
           border border-slate-200/80
           rounded-[32px]
           min-h-screen
           lg:sticky top-5
           shadow-[0_26px_60px_rgba(15,23,42,0.06)]
           backdrop-blur-xl
           overflow-hidden"
>

    <!-- ========================================================= -->
    <!-- SIDEBAR HEADER -->
    <!-- ========================================================= -->

    <div class="h-28 border-b border-slate-200/80 px-5 flex items-center">

        <div class="flex items-center gap-3 w-full">

            <!-- LOGO -->
            <div class="w-16 h-16 flex items-center justify-center shrink-0">

                <img
                    src="{{ asset('images/karsa-nirmala-logo.png') }}"
                    alt="Karsa Nirmala logo"
                    class="w-16 h-16 object-contain scale-[1.8] drop-shadow-sm"
                >

            </div>


            <!-- BRAND -->
            <div class="min-w-0 flex-1">

                <h2
                    class="font-black
                           text-[1.45rem]
                           leading-none
                           tracking-tight
                           text-slate-900
                           whitespace-nowrap"
                >
                    Karsa Nirmala
                </h2>

                <p
                    class="mt-1
                           text-[0.65rem]
                           text-slate-500
                           leading-snug
                           font-medium"
                >
                    Sistem Cerdas Pengelolaan Sampah | Ekonomi Sirkular
                </p>

            </div>

        </div>

    </div>


    <!-- ========================================================= -->
    <!-- SIDEBAR CONTENT -->
    <!-- ========================================================= -->

    @php
        $isDashboard = request()->routeIs('dashboard');
        $isScanner = request()->routeIs(['scanner', 'scanner.history']);
        $isBankSampah = request()->routeIs('bank-sampah');
        $isMarketplace = request()->routeIs('marketplace');
    @endphp

    <div class="p-4 sidebar-scroll overflow-y-auto min-h-[calc(100vh-7rem)]">

        <!-- MAIN MENU -->
        <p class="text-xs uppercase font-bold text-slate-400 px-3 mb-3">
            Main Menu
        </p>


        <nav class="space-y-2">

            <!-- ================================================= -->
            <!-- DASHBOARD -->
            <!-- ================================================= -->

            <a
                href="{{ route('dashboard') }}"
                class="flex items-center gap-3 p-3 rounded-2xl
                       {{ $isDashboard ? 'bg-lime-50 text-lime-700 border border-lime-200 shadow-sm' : 'hover:bg-slate-50 hover:text-lime-700' }}
                       transition-colors duration-200"
            >

                <span
                    class="w-10 h-10 rounded-2xl
                           bg-white
                           flex items-center justify-center
                           text-lime-600
                           shadow-sm
                           shrink-0"
                >

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >

                        <path d="M3 9.5L12 3l9 6.5v11a1 1 0 0 1-1 1h-5a1 1 0 0 1-1-1V15H10v6.5a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1v-11z" />

                    </svg>

                </span>

                <span class="font-semibold">
                    Dashboard
                </span>

            </a>


            <!-- ================================================= -->
            <!-- AI SCANNER -->
            <!-- ================================================= -->

            <a
                href="{{ route('scanner') }}"
                class="flex items-center gap-3 p-3 rounded-2xl
                       {{ $isScanner ? 'bg-lime-50 text-lime-700 border border-lime-200 shadow-sm' : 'hover:bg-slate-50 hover:text-lime-700' }}
                       transition-colors duration-200"
            >

                <span
                    class="w-10 h-10 rounded-2xl
                           bg-slate-100
                           flex items-center justify-center
                           text-slate-600
                           shrink-0"
                >

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >

                        <rect
                            x="3"
                            y="7"
                            width="18"
                            height="13"
                            rx="2"
                            ry="2"
                        />

                        <path
                            d="M16 3H8a2 2 0 0 0-2 2v2h12V5a2 2 0 0 0-2-2z"
                        />

                        <path d="M12 11v6" />

                    </svg>

                </span>

                <span class="font-semibold">
                    AI Scanner
                </span>

            </a>


            <!-- ================================================= -->
            <!-- HISTORY -->
            <!-- ================================================= -->

            <a
                href="{{ route('scanner.history') }}"
                class="flex items-center gap-3 p-3 rounded-2xl
                       hover:bg-lime-50
                       hover:text-lime-600
                       transition-colors duration-200"
            >

                <span
                    class="w-10 h-10 rounded-2xl
                           bg-slate-100
                           flex items-center justify-center
                           text-slate-600
                           shrink-0"
                >

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >

                        <path d="M4 19h16" />
                        <path d="M4 12h16" />
                        <path d="M4 5h16" />

                    </svg>

                </span>

                <span class="font-semibold">
                    History Scan
                </span>

            </a>


            <!-- ================================================= -->
            <!-- GIS -->
            <!-- ================================================= -->

            <a
                href="{{ route('bank-sampah') }}"
                class="flex items-center gap-3 p-3 rounded-2xl
                       {{ $isBankSampah ? 'bg-lime-50 text-lime-700 border border-lime-200 shadow-sm' : 'hover:bg-lime-50 hover:text-lime-600' }}
                       transition-colors duration-200"
            >

                <span
                    class="w-10 h-10 rounded-2xl
                           bg-slate-100
                           flex items-center justify-center
                           text-slate-600
                           shrink-0"
                >

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >

                        <path d="M3 6l4-1 5 2 5-2 4 1v12l-4 1-5-2-5 2-4-1V6z" />
                        <path d="M8 5v12" />
                        <path d="M13 7v10" />
                        <circle cx="12" cy="12" r="1.5" fill="currentColor" />

                    </svg>

                </span>

                <span class="font-semibold">
                    GIS
                </span>

            </a>

            <!-- ================================================= -->
            <!-- MARKETPLACE -->
            <!-- ================================================= -->

            <a
                href="{{ route('marketplace') }}"
                class="flex items-center gap-3 p-3 rounded-2xl
                       {{ $isMarketplace ? 'bg-lime-50 text-lime-700 border border-lime-200 shadow-sm' : 'hover:bg-lime-50 hover:text-lime-600' }}
                       transition-colors duration-200"
            >

                <span
                    class="w-10 h-10 rounded-2xl
                           bg-slate-100
                           flex items-center justify-center
                           text-slate-600
                           shrink-0"
                >

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >

                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>

                    </svg>

                </span>

                <span class="font-semibold">
                    Marketplace
                </span>

            </a>

            <!-- ================================================= -->
            <!-- AI CHATBOT -->
            <!-- ================================================= -->

            <a
                href="{{ route('chatbot') }}"
                class="flex items-center gap-3 p-3 rounded-2xl
                       hover:bg-lime-50
                       hover:text-lime-600
                       transition-colors duration-200"
            >

                <span
                    class="w-10 h-10 rounded-2xl
                           bg-slate-100
                           flex items-center justify-center
                           text-slate-600
                           shrink-0"
                >

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >

                        <path
                            d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"
                        />

                    </svg>

                </span>

                <span class="font-semibold">
                    AI Chatbot
                </span>

            </a>


            <!-- ================================================= -->
            <!-- PROFILE -->
            <!-- ================================================= -->

            <a
                href="{{ route('profile') }}"
                class="flex items-center gap-3 p-3 rounded-2xl
                       hover:bg-lime-50
                       hover:text-lime-600
                       transition-colors duration-200"
            >

                <span
                    class="w-10 h-10 rounded-2xl
                           bg-slate-100
                           flex items-center justify-center
                           text-slate-600
                           shrink-0"
                >

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >

                        <path
                            d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"
                        />

                        <circle
                            cx="12"
                            cy="7"
                            r="4"
                        />

                    </svg>

                </span>

                <span class="font-semibold">
                    Profile
                </span>

            </a>


            <!-- ================================================= -->
            <!-- LOGOUT -->
            <!-- ================================================= -->

            <form
                action="{{ route('logout') }}"
                method="POST"
            >

                @csrf

                <button
                    type="submit"
                    class="w-full text-left
                           flex items-center gap-3 p-3 rounded-2xl
                           text-red-500
                           hover:bg-red-50
                           transition-colors duration-200"
                >

                    <span
                        class="w-10 h-10 rounded-2xl
                               bg-slate-100
                               flex items-center justify-center
                               text-red-500
                               shrink-0"
                    >

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="w-5 h-5"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >

                            <path
                                d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"
                            />

                            <polyline points="16 17 21 12 16 7" />

                            <line
                                x1="21"
                                y1="12"
                                x2="9"
                                y2="12"
                            />

                        </svg>

                    </span>

                    <span class="font-semibold">
                        Logout
                    </span>

                </button>

            </form>

        </nav>

    </div>

</aside>