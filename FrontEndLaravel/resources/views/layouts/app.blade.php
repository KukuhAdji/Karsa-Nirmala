<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SmartWaste AI') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }

        .sidebar-scroll::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 10px;
        }

        @keyframes pageEnter {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-page-enter {
            animation: pageEnter 0.4s ease-out forwards;
        }
    </style>

    @stack('styles')
</head>

<body class="bg-[#eef5ee] text-slate-800 overflow-x-hidden antialiased">

<div class="min-h-screen">
    <div class="flex flex-col lg:flex-row lg:gap-6 max-w-[1600px] mx-auto px-3 py-3 lg:px-5 lg:py-5">

        <!-- Sidebar -->
        <div
            id="mobileSidebar"
            class="fixed inset-y-0 left-0 z-50 w-full max-w-xs transform -translate-x-full transition-transform duration-300 ease-in-out"
        >
            <x-sidebar />
        </div>

        <!-- Backdrop -->
        <div
            id="sidebarBackdrop"
            class="fixed inset-0 bg-slate-900/40 opacity-0 pointer-events-none transition-opacity duration-300 ease-in-out z-40"
        ></div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col lg:overflow-hidden">

            <x-navbar />

            <main class="p-4 sm:p-6 lg:p-7 min-h-[calc(100vh-5rem)] animate-page-enter">
                @isset($slot)
                    {{ $slot }}
                @endisset

                @yield('content')
            </main>

        </div>

    </div>
</div>

@stack('scripts')

<div id="floatingChatbot" class="fixed z-50 flex cursor-grab items-center justify-center rounded-full bg-gradient-to-br from-lime-400 to-green-600 p-4 text-2xl text-white shadow-[0_24px_50px_rgba(34,197,94,0.35)] transition-all duration-200 active:cursor-grabbing hover:scale-105">
    <a href="{{ route('chatbot') }}" class="flex items-center justify-center" aria-label="Open AI Chatbot" title="AI Chatbot">
        🤖
    </a>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const floatingChatbot = document.getElementById('floatingChatbot');
        if (!floatingChatbot) return;

        let isDragging = false;
        let offsetX = 0;
        let offsetY = 0;

        const updatePosition = (x, y) => {
            const maxX = window.innerWidth - floatingChatbot.offsetWidth;
            const maxY = window.innerHeight - floatingChatbot.offsetHeight;
            const nextX = Math.min(Math.max(20, x), maxX - 20);
            const nextY = Math.min(Math.max(20, y), maxY - 20);
            floatingChatbot.style.left = nextX + 'px';
            floatingChatbot.style.top = nextY + 'px';
        };

        floatingChatbot.addEventListener('pointerdown', function (event) {
            isDragging = true;
            floatingChatbot.setPointerCapture(event.pointerId);
            const rect = floatingChatbot.getBoundingClientRect();
            offsetX = event.clientX - rect.left;
            offsetY = event.clientY - rect.top;
            floatingChatbot.style.transition = 'none';
        });

        floatingChatbot.addEventListener('pointermove', function (event) {
            if (!isDragging) return;
            const x = event.clientX - offsetX;
            const y = event.clientY - offsetY;
            updatePosition(x, y);
        });

        floatingChatbot.addEventListener('pointerup', function () {
            isDragging = false;
            floatingChatbot.style.transition = 'transform 0.2s ease, box-shadow 0.2s ease';
        });

        floatingChatbot.addEventListener('pointerleave', function () {
            isDragging = false;
            floatingChatbot.style.transition = 'transform 0.2s ease, box-shadow 0.2s ease';
        });

        const saved = localStorage.getItem('floatingChatbotPosition');
        if (saved) {
            try {
                const pos = JSON.parse(saved);
                updatePosition(pos.x || 20, pos.y || 120);
            } catch (e) {
                updatePosition(20, 120);
            }
        } else {
            updatePosition(20, 120);
        }

        floatingChatbot.addEventListener('pointerup', function () {
            const x = parseFloat(floatingChatbot.style.left || 20);
            const y = parseFloat(floatingChatbot.style.top || 120);
            localStorage.setItem('floatingChatbotPosition', JSON.stringify({ x, y }));
        });
    });
</script>

</body>
</html>
