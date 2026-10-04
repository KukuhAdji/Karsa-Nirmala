<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>
        @yield('title', 'Admin Dashboard') - Karsa Nirmala
    </title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    <link
        href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet"
    >

    <style>

        body {
            font-family: 'Nunito', sans-serif;
        }

        .sidebar-scroll::-webkit-scrollbar {
            width: 5px;
        }

        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 999px;
        }

    </style>

    @stack('styles')

</head>


<body class="bg-[#eef5ee] text-slate-800 antialiased">


<div
    class="min-h-screen
           w-screen
           overflow-x-hidden"
>


    {{-- ===================================================== --}}
    {{-- DESKTOP / MOBILE SIDEBAR --}}
    {{-- ===================================================== --}}

    <div
        id="mobileSidebar"
        class="fixed inset-y-0 left-0 z-50
               w-full max-w-xs
               -translate-x-full
               transform
               overflow-y-auto
               transition-transform duration-300
               ease-in-out

               lg:static
               lg:block
               lg:w-auto
               lg:max-w-none
               lg:translate-x-0
               lg:overflow-visible"
    >

        <x-admin-sidebar />

    </div>


    {{-- ===================================================== --}}
    {{-- SIDEBAR BACKDROP --}}
    {{-- ===================================================== --}}

    <div
        id="sidebarBackdrop"
        class="fixed inset-0 z-40
               bg-slate-900/40
               opacity-0
               pointer-events-none
               transition-opacity duration-300
               lg:hidden"
    ></div>


    {{-- ===================================================== --}}
    {{-- MAIN --}}
    {{-- ===================================================== --}}

    <div
        class="flex min-h-screen
               flex-col
               lg:ml-0
               lg:pl-0"
    >

        <div
            class="flex w-full
                   flex-col
                   lg:max-w-[1600px]
                   lg:mx-auto
                   lg:px-5
                   lg:py-5
                   lg:pl-[20.5rem]"
        >


            {{-- ================================================= --}}
            {{-- EXISTING HEADER --}}
            {{-- ================================================= --}}

            <x-navbar />


            {{-- ================================================= --}}
            {{-- CONTENT --}}
            {{-- ================================================= --}}

            <main
                class="min-h-[calc(100vh-5rem)]
                       p-4
                       sm:p-6
                       lg:p-7
                       animate-page-enter"
            >

                @yield('content')

            </main>

        </div>

    </div>

</div>


@stack('scripts')

</body>

</html>