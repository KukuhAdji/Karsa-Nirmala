<aside
    class="w-full max-w-xs lg:w-72 lg:flex-none
           bg-white
           border border-slate-200
           rounded-[28px]
           min-h-screen
           lg:sticky lg:top-5
           shadow-[0_20px_50px_rgba(15,23,42,0.06)]
           overflow-hidden"
>

    {{-- ========================================================= --}}
    {{-- ADMIN SIDEBAR HEADER --}}
    {{-- ========================================================= --}}

    <div class="border-b border-slate-200 px-5 py-6">

        <div class="flex items-center gap-3">

            {{-- Logo --}}
            <div
                class="flex h-16 w-16 shrink-0
                       items-center justify-center"
            >

                <img
                    src="{{ asset('images/karsa-nirmala-logo.png') }}"
                    alt="Karsa Nirmala"
                    class="h-14 w-14 object-contain"
                >

            </div>

            {{-- Brand --}}
            <div class="min-w-0">

                <h2
                    class="text-[1.35rem]
                           font-black
                           leading-none
                           tracking-tight
                           text-slate-900"
                >
                    Karsa Nirmala
                </h2>

                <p
                    class="mt-1.5
                           text-[0.68rem]
                           font-semibold
                           uppercase
                           tracking-wider
                           text-lime-600"
                >
                    Super Admin
                </p>

            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- NAVIGATION --}}
    {{-- ========================================================= --}}

    <div
        class="sidebar-scroll
               min-h-[calc(100vh-9rem)]
               overflow-y-auto
               p-4"
    >

        {{-- MAIN MENU --}}
        <p
            class="mb-3 px-3
                   text-[11px]
                   font-black
                   uppercase
                   tracking-[0.12em]
                   text-slate-400"
        >
            Main Menu
        </p>


        <nav class="space-y-1.5">


            {{-- ================================================= --}}
            {{-- DASHBOARD --}}
            {{-- ================================================= --}}

            <a
                href="{{ route('admin.dashboard') }}"
                class="group flex items-center gap-3
                       rounded-2xl px-3 py-3
                       transition-all duration-200

                       {{ request()->routeIs('admin.dashboard')
                            ? 'bg-lime-50 text-lime-700'
                            : 'text-slate-600 hover:bg-slate-50 hover:text-lime-700' }}"
            >

                <span
                    class="flex h-10 w-10 shrink-0
                           items-center justify-center
                           rounded-xl
                           {{ request()->routeIs('admin.dashboard')
                                ? 'bg-white text-lime-600 shadow-sm'
                                : 'bg-slate-50 text-slate-500 group-hover:bg-white group-hover:text-lime-600' }}"
                >

                    {{-- Dashboard --}}
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path d="M3 10.5 12 3l9 7.5" />
                        <path d="M5 9.5V21h14V9.5" />
                        <path d="M9 21v-6h6v6" />
                    </svg>

                </span>

                <span class="font-bold">
                    Dashboard
                </span>

            </a>


            {{-- ================================================= --}}
            {{-- MANAJEMEN AKUN --}}
            {{-- ================================================= --}}

            <a
                href="{{ route('admin.users.index') }}"
                class="group flex items-center gap-3
                       rounded-2xl px-3 py-3
                       text-slate-600
                       transition-all duration-200
                       hover:bg-slate-50
                       hover:text-lime-700"
            >

                <span
                    class="flex h-10 w-10 shrink-0
                           items-center justify-center
                           rounded-xl
                           bg-slate-50
                           text-slate-500
                           group-hover:bg-white
                           group-hover:text-lime-600"
                >

                    {{-- Users --}}
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                    </svg>

                </span>

                <span class="font-bold">
                    Manajemen Akun
                </span>

            </a>


            {{-- ================================================= --}}
            {{-- BANK SAMPAH --}}
            {{-- ================================================= --}}

            <a
                href="route('admin.manage-bank-sampah.index')"
                class="group flex items-center gap-3
                       rounded-2xl px-3 py-3
                       text-slate-600
                       transition-all duration-200
                       hover:bg-slate-50
                       hover:text-lime-700"
            >

                <span
                    class="flex h-10 w-10 shrink-0
                           items-center justify-center
                           rounded-xl
                           bg-slate-50
                           text-slate-500
                           group-hover:bg-white
                           group-hover:text-lime-600"
                >

                    {{-- Building / Bank --}}
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path d="M3 21h18" />
                        <path d="M5 21V7l7-4 7 4v14" />
                        <path d="M9 21v-4h6v4" />
                        <path d="M8 10h1" />
                        <path d="M12 10h1" />
                        <path d="M16 10h1" />
                        <path d="M8 13h1" />
                        <path d="M12 13h1" />
                        <path d="M16 13h1" />
                    </svg>

                </span>

                <span class="font-bold">
                    Bank Sampah
                </span>

            </a>


            {{-- ================================================= --}}
            {{-- MARKETPLACE --}}
            {{-- ================================================= --}}

            <a
                href="#"
                class="group flex items-center gap-3
                       rounded-2xl px-3 py-3
                       text-slate-600
                       transition-all duration-200
                       hover:bg-slate-50
                       hover:text-lime-700"
            >

                <span
                    class="flex h-10 w-10 shrink-0
                           items-center justify-center
                           rounded-xl
                           bg-slate-50
                           text-slate-500
                           group-hover:bg-white
                           group-hover:text-lime-600"
                >

                    {{-- Shopping Bag --}}
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path d="M6 8h12l1 13H5L6 8Z" />
                        <path d="M9 8V6a3 3 0 0 1 6 0v2" />
                    </svg>

                </span>

                <span class="font-bold">
                    Marketplace
                </span>

            </a>


            {{-- ================================================= --}}
            {{-- PESANAN --}}
            {{-- ================================================= --}}

            <a
                href="#"
                class="group flex items-center gap-3
                       rounded-2xl px-3 py-3
                       text-slate-600
                       transition-all duration-200
                       hover:bg-slate-50
                       hover:text-lime-700"
            >

                <span
                    class="flex h-10 w-10 shrink-0
                           items-center justify-center
                           rounded-xl
                           bg-slate-50
                           text-slate-500
                           group-hover:bg-white
                           group-hover:text-lime-600"
                >

                    {{-- Clipboard --}}
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <rect
                            x="4"
                            y="4"
                            width="16"
                            height="17"
                            rx="2"
                        />

                        <path d="M9 4V3h6v1" />
                        <path d="M8 10h8" />
                        <path d="M8 14h8" />
                        <path d="M8 18h5" />
                    </svg>

                </span>

                <span class="font-bold">
                    Pesanan
                </span>

            </a>

        </nav>


        {{-- ================================================= --}}
        {{-- SYSTEM --}}
        {{-- ================================================= --}}

        <div class="my-6 border-t border-slate-100"></div>

        <p
            class="mb-3 px-3
                   text-[11px]
                   font-black
                   uppercase
                   tracking-[0.12em]
                   text-slate-400"
        >
            System
        </p>


        <nav class="space-y-1.5">

            {{-- Activity Log --}}
            <a
                href="#"
                class="group flex items-center gap-3
                       rounded-2xl px-3 py-3
                       text-slate-600
                       transition-all duration-200
                       hover:bg-slate-50
                       hover:text-lime-700"
            >

                <span
                    class="flex h-10 w-10 shrink-0
                           items-center justify-center
                           rounded-xl
                           bg-slate-50
                           text-slate-500
                           group-hover:bg-white
                           group-hover:text-lime-600"
                >

                    {{-- Activity --}}
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path d="M3 12h4l2-7 4 14 2-7h6" />
                    </svg>

                </span>

                <span class="font-bold">
                    Activity Log
                </span>

            </a>

        </nav>

    </div>


    {{-- ========================================================= --}}
    {{-- ADMIN PROFILE / LOGOUT --}}
    {{-- ========================================================= --}}

    <div class="border-t border-slate-200 p-4">

        <div
            class="mb-3 flex items-center gap-3
                   rounded-2xl bg-slate-50 p-3"
        >

            <div
                class="flex h-10 w-10 shrink-0
                       items-center justify-center
                       rounded-full
                       bg-lime-100
                       font-black
                       text-lime-700"
            >
                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
            </div>

            <div class="min-w-0">

                <p
                    class="truncate
                           text-sm
                           font-black
                           text-slate-800"
                >
                    {{ auth()->user()->name }}
                </p>

                <p
                    class="text-xs
                           font-semibold
                           text-slate-500"
                >
                    Super Administrator
                </p>

            </div>

        </div>


        {{-- Logout --}}
        <form
            action="{{ route('logout') }}"
            method="POST"
        >

            @csrf

            <button
                type="submit"
                class="group flex w-full
                       items-center gap-3
                       rounded-2xl px-3 py-3
                       text-left
                       text-slate-600
                       transition-all duration-200
                       hover:bg-red-50
                       hover:text-red-600"
            >

                <span
                    class="flex h-10 w-10
                           shrink-0
                           items-center
                           justify-center
                           rounded-xl
                           bg-slate-50
                           text-slate-500
                           group-hover:bg-white
                           group-hover:text-red-500"
                >

                    {{-- Logout --}}
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                        <polyline points="16 17 21 12 16 7" />
                        <line x1="21" y1="12" x2="9" y2="12" />
                    </svg>

                </span>

                <span class="font-bold">
                    Logout
                </span>

            </button>

        </form>

    </div>

</aside>