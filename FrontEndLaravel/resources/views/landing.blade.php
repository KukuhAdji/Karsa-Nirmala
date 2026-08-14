@extends('layouts.guest')

@section('content')

<nav class="fixed top-0 inset-x-0 z-50 border-b border-slate-200/80 bg-white/90 backdrop-blur-xl">
    <div class="max-w-7xl mx-auto px-6">
        <div class="h-20 flex items-center justify-between">

            {{-- Logo --}}
            <a href="#"
               class="group flex items-center gap-3"
               aria-label="WISE Home">

                <div class="relative w-16 h-16 shrink-0">
                    <img src="{{ asset('images/karsa-nirmala-logo.png') }}" alt="Karsa Nirmala logo" class="h-16 w-16 object-contain scale-[1.8] drop-shadow-sm">
                </div>

                <div class="leading-tight">
                    <div class="flex items-center gap-2">
                        <h1 class="text-xl font-black tracking-tight text-slate-900 transition-colors duration-300 group-hover:text-lime-600">
                            Karsa Nirmala
                        </h1>

                        <span class="hidden sm:inline-flex items-center rounded-full bg-lime-50 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider text-lime-700 ring-1 ring-inset ring-lime-200">
                            AI Platform
                        </span>
                    </div>

                    <p class="hidden sm:block mt-1 text-xs font-medium text-slate-500">
                        Sistem Cerdas Pengelolaan Sampah | Ekonomi Sirkular
                    </p>
                </div>
            </a>

            {{-- Desktop Navigation --}}
            <div class="hidden md:flex items-center rounded-full border border-slate-200 bg-slate-50/80 p-1.5 shadow-sm">
                <a href="#features"
                   class="group relative rounded-full px-5 py-2 text-sm font-semibold text-slate-600 transition duration-200 hover:bg-white hover:text-lime-700 hover:shadow-sm">
                    Tentang Karsa
                </a>

                <a href="#how"
                   class="group relative rounded-full px-5 py-2 text-sm font-semibold text-slate-600 transition duration-200 hover:bg-white hover:text-lime-700 hover:shadow-sm">
                    How It Works
                </a>

                <a href="#education"
                   class="group relative rounded-full px-5 py-2 text-sm font-semibold text-slate-600 transition duration-200 hover:bg-white hover:text-lime-700 hover:shadow-sm">
                    Education
                </a>
            </div>

            {{-- Desktop Actions and Mobile Toggle --}}
            <div class="flex items-center gap-3">

                <a href="{{ route('login') }}"
                   class="hidden md:inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-lime-500 to-green-600 px-5 text-sm font-bold text-white shadow-lg shadow-lime-500/20 transition duration-200 hover:-translate-y-0.5 hover:shadow-xl hover:shadow-lime-500/30 focus:outline-none focus:ring-4 focus:ring-lime-200">
                    Get Started

                    <svg xmlns="http://www.w3.org/2000/svg"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="2"
                         stroke-linecap="round"
                         stroke-linejoin="round"
                         class="w-4 h-4">
                        <path d="M5 12h14"></path>
                        <path d="m13 6 6 6-6 6"></path>
                    </svg>
                </a>

                <button id="mobileMenuToggle"
                        type="button"
                        class="md:hidden inline-flex h-11 w-11 items-center justify-center rounded-xl border border-slate-200 bg-slate-50 text-slate-700 transition duration-200 hover:border-lime-300 hover:bg-lime-50 hover:text-lime-700 focus:outline-none focus:ring-4 focus:ring-lime-100"
                        aria-label="Open navigation menu"
                        aria-controls="mobileMenu"
                        aria-expanded="false">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="w-5 h-5"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

            </div>
        </div>
    </div>

    {{-- Mobile Navigation --}}
    <div id="mobileMenu"
         class="md:hidden hidden border-t border-slate-200 bg-white/95 backdrop-blur-xl">
        <div class="max-w-7xl mx-auto px-6 py-5">

            <div class="space-y-1">
                <a href="#features"
                   class="flex items-center justify-between rounded-xl px-4 py-3 text-sm font-bold text-slate-700 transition hover:bg-lime-50 hover:text-lime-700">
                    <span>About WISE</span>

                    <svg xmlns="http://www.w3.org/2000/svg"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="2"
                         class="w-4 h-4">
                        <path d="m9 18 6-6-6-6"></path>
                    </svg>
                </a>

                <a href="#how"
                   class="flex items-center justify-between rounded-xl px-4 py-3 text-sm font-bold text-slate-700 transition hover:bg-lime-50 hover:text-lime-700">
                    <span>How It Works</span>

                    <svg xmlns="http://www.w3.org/2000/svg"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="2"
                         class="w-4 h-4">
                        <path d="m9 18 6-6-6-6"></path>
                    </svg>
                </a>

                <a href="#education"
                   class="flex items-center justify-between rounded-xl px-4 py-3 text-sm font-bold text-slate-700 transition hover:bg-lime-50 hover:text-lime-700">
                    <span>Education</span>

                    <svg xmlns="http://www.w3.org/2000/svg"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="2"
                         class="w-4 h-4">
                        <path d="m9 18 6-6-6-6"></path>
                    </svg>
                </a>
            </div>

            <div class="mt-5 grid grid-cols-1 gap-3 border-t border-slate-200 pt-5">
                <a href="{{ route('login') }}"
                   class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-lime-500 to-green-600 px-4 py-3 text-sm font-bold text-white shadow-lg shadow-lime-500/20 transition hover:shadow-xl">
                    Get Started

                    <svg xmlns="http://www.w3.org/2000/svg"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="2"
                         class="w-4 h-4">
                        <path d="M5 12h14"></path>
                        <path d="m13 6 6 6-6 6"></path>
                    </svg>
                </a>
            </div>

        </div>
    </div>
</nav>

<section class="relative overflow-hidden bg-gradient-to-b from-lime-50 via-white to-white pt-36 pb-24">

    {{-- Decorative background --}}
    <div class="pointer-events-none absolute -left-32 top-16 h-96 w-96 rounded-full bg-lime-200/40 blur-3xl"></div>
    <div class="pointer-events-none absolute -right-32 top-24 h-96 w-96 rounded-full bg-emerald-200/30 blur-3xl"></div>

    <div class="pointer-events-none absolute inset-0 opacity-[0.035]"
         style="background-image: radial-gradient(#65a30d 1px, transparent 1px); background-size: 28px 28px;">
    </div>

    <div class="relative max-w-7xl mx-auto px-6">

        <div class="grid items-center gap-14 lg:grid-cols-[1.05fr_0.95fr]">

            {{-- Hero content --}}
            <div class="max-w-3xl">

                <div class="mb-7 inline-flex items-center gap-2 rounded-full border border-lime-200 bg-white/80 px-4 py-2 text-sm font-bold text-lime-700 shadow-sm backdrop-blur">
                    <span class="flex h-7 w-7 items-center justify-center rounded-full bg-lime-100 text-lime-700">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="2"
                             stroke-linecap="round"
                             stroke-linejoin="round"
                             class="h-4 w-4">
                            <path d="M12 22V8"></path>
                            <path d="M5 12H2a10 10 0 0 0 10 10"></path>
                            <path d="M22 2a10 10 0 0 1-10 10V7a5 5 0 0 1 5-5Z"></path>
                        </svg>
                    </span>
                    AI Powered Environmental Platform
                </div>

                <h1 class="max-w-3xl text-4xl font-black leading-[1.08] tracking-tight text-slate-900 sm:text-5xl lg:text-6xl">
                    Saka Karsa Becik
                    <span class="bg-gradient-to-r from-lime-500 to-green-600 bg-clip-text text-transparent">
                        Tumuju Bawana Resik
                    </span>
                </h1>

                <p class="mt-7 max-w-2xl text-lg leading-8 text-slate-500 sm:text-xl">
                    Kenali sampah secara instan dengan teknologi AI, 
                    temukan cara pengolahan yang tepat, dan mulai perubahan baik dari langkah sederhana.
                </p>

                <div class="mt-9 flex flex-col gap-4 sm:flex-row sm:flex-wrap">

                    {{-- Primary button --}}
                    <div class="group relative w-full sm:w-auto">
                        <div class="absolute -inset-1 rounded-2xl bg-gradient-to-r from-lime-400 to-green-500 opacity-0 blur-lg transition duration-300 group-hover:opacity-70"></div>

                        <a href="{{ route('login') }}"
                           class="relative inline-flex h-14 w-full items-center justify-center gap-3 overflow-hidden rounded-2xl bg-gradient-to-r from-lime-500 to-green-600 px-7 text-base font-bold text-white shadow-lg shadow-lime-500/25 transition duration-300 hover:-translate-y-1 hover:shadow-2xl hover:shadow-lime-500/30 focus:outline-none focus:ring-4 focus:ring-lime-200 sm:w-auto">

                            <span class="absolute inset-0 -translate-x-full bg-gradient-to-r from-transparent via-white/25 to-transparent transition-transform duration-700 group-hover:translate-x-full"></span>

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="2"
                                 stroke-linecap="round"
                                 stroke-linejoin="round"
                                 class="relative h-5 w-5 transition duration-300 group-hover:rotate-6 group-hover:scale-110">
                                <path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3Z"></path>
                                <circle cx="12" cy="13" r="3"></circle>
                            </svg>

                            <span class="relative">Start Scanning</span>

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="2"
                                 stroke-linecap="round"
                                 stroke-linejoin="round"
                                 class="relative h-5 w-5 transition-transform duration-300 group-hover:translate-x-1">
                                <path d="M5 12h14"></path>
                                <path d="m13 6 6 6-6 6"></path>
                            </svg>
                        </a>
                    </div>

                    {{-- Secondary button --}}
                    <div class="group relative w-full sm:w-auto">
                        <div class="absolute -inset-1 rounded-2xl bg-lime-300/50 opacity-0 blur-lg transition duration-300 group-hover:opacity-70"></div>

                        <a href="#features"
                           class="relative inline-flex h-14 w-full items-center justify-center gap-3 rounded-2xl border border-slate-200 bg-white/90 px-7 text-base font-bold text-slate-700 shadow-sm backdrop-blur transition duration-300 hover:-translate-y-1 hover:border-lime-300 hover:bg-lime-50 hover:text-lime-700 hover:shadow-xl hover:shadow-lime-500/10 focus:outline-none focus:ring-4 focus:ring-lime-100 sm:w-auto">

                            <span>Learn More</span>

                            <span class="flex h-7 w-7 items-center justify-center rounded-full bg-slate-100 transition duration-300 group-hover:bg-lime-200 group-hover:text-lime-800">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 24 24"
                                     fill="none"
                                     stroke="currentColor"
                                     stroke-width="2"
                                     stroke-linecap="round"
                                     stroke-linejoin="round"
                                     class="h-4 w-4 transition-transform duration-300 group-hover:translate-y-0.5">
                                    <path d="m6 9 6 6 6-6"></path>
                                </svg>
                            </span>
                        </a>
                    </div>

                </div>

                <div class="mt-8 flex flex-wrap gap-3 text-sm font-semibold text-slate-500">
                    <span class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white/80 px-3 py-2 shadow-sm">
                        <span class="h-2 w-2 rounded-full bg-lime-500 shadow-[0_0_10px_rgba(132,204,22,0.8)]"></span>
                        Instant classification
                    </span>

                    <span class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white/80 px-3 py-2 shadow-sm">
                        <span class="h-2 w-2 rounded-full bg-green-500 shadow-[0_0_10px_rgba(34,197,94,0.8)]"></span>
                        Economic value insights
                    </span>

                     <span class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white/80 px-3 py-2 shadow-sm">
                        <span class="h-2 w-2 rounded-full bg-green-500 shadow-[0_0_10px_rgba(34,197,94,0.8)]"></span>
                        Geographic Information System (GIS) integration
                    </span>
                </div>

            </div>

            {{-- Waste category showcase --}}
            <div class="group relative">

                <div class="absolute -inset-4 rounded-[40px] bg-gradient-to-br from-lime-300/50 via-green-300/30 to-emerald-300/40 opacity-60 blur-3xl transition duration-500 group-hover:opacity-90"></div>

                <div class="relative overflow-hidden rounded-[34px] border border-white/80 bg-white/85 p-6 shadow-[0_24px_80px_rgba(15,23,42,0.14)] ring-1 ring-slate-200/70 backdrop-blur-xl transition duration-500 group-hover:-translate-y-1 group-hover:shadow-[0_28px_90px_rgba(34,197,94,0.20)] sm:p-8">

                    <div class="absolute -right-16 -top-16 h-48 w-48 rounded-full bg-lime-100/80 blur-2xl"></div>
                    <div class="absolute -bottom-20 -left-16 h-48 w-48 rounded-full bg-emerald-100/70 blur-2xl"></div>

                    <div class="relative mb-6 flex items-center justify-between gap-4">

                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.18em] text-lime-600">
                                Waste Categories
                            </p>

                            <h2 class="mt-1 text-xl font-black text-slate-900">
                                Identify. Learn. Take Action.
                            </h2>
                        </div>

                        <span class="inline-flex items-center gap-2 rounded-full border border-lime-200 bg-lime-50 px-3 py-1.5 text-xs font-bold text-lime-700">
                            <span class="h-2 w-2 rounded-full bg-lime-500 shadow-[0_0_10px_rgba(132,204,22,0.8)]"></span>
                            AI Ready
                        </span>

                    </div>

                    <div class="relative grid grid-cols-1 gap-4 sm:grid-cols-2">

                        {{-- Organic --}}
                        <div class="group/card relative overflow-hidden rounded-[24px] border border-emerald-200/80 bg-gradient-to-br from-emerald-50 to-green-100/80 p-5 transition duration-300 hover:-translate-y-1.5 hover:border-emerald-300 hover:shadow-[0_18px_40px_rgba(16,185,129,0.22)]">

                            <div class="absolute -right-6 -top-6 h-20 w-20 rounded-full bg-emerald-200/60 blur-xl transition duration-300 group-hover/card:scale-125"></div>

                            <div class="relative flex items-start justify-between">
                                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white text-emerald-600 shadow-md shadow-emerald-500/10 transition duration-300 group-hover/card:-rotate-3 group-hover/card:scale-110">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         viewBox="0 0 24 24"
                                         fill="none"
                                         stroke="currentColor"
                                         stroke-width="2"
                                         stroke-linecap="round"
                                         stroke-linejoin="round"
                                         class="h-6 w-6">
                                        <path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 18 2 18 2c1 5-1 10-5 12"></path>
                                        <path d="M2 21c0-3 1.85-5.36 5.08-6.94C9.33 12.96 12 12 16 12"></path>
                                    </svg>
                                </div>

                                <span class="rounded-full bg-white/80 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-emerald-700">
                                    Natural
                                </span>
                            </div>

                            <div class="relative mt-5">
                                <h3 class="text-lg font-black text-slate-900">Organic</h3>
                                <p class="mt-1 text-xs font-medium text-slate-500">
                                    Food and natural waste
                                </p>
                            </div>

                        </div>

                        {{-- Anorganic --}}
                        <div class="group/card relative overflow-hidden rounded-[24px] border border-blue-200/80 bg-gradient-to-br from-blue-50 to-cyan-100/80 p-5 transition duration-300 hover:-translate-y-1.5 hover:border-blue-300 hover:shadow-[0_18px_40px_rgba(59,130,246,0.22)]">

                            <div class="absolute -right-6 -top-6 h-20 w-20 rounded-full bg-blue-200/60 blur-xl transition duration-300 group-hover/card:scale-125"></div>

                            <div class="relative flex items-start justify-between">
                                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white text-blue-600 shadow-md shadow-blue-500/10 transition duration-300 group-hover/card:rotate-3 group-hover/card:scale-110">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         viewBox="0 0 24 24"
                                         fill="none"
                                         stroke="currentColor"
                                         stroke-width="2"
                                         stroke-linecap="round"
                                         stroke-linejoin="round"
                                         class="h-6 w-6">
                                        <path d="M12 2v6"></path>
                                        <path d="m5 9 7-4 7 4-7 4Z"></path>
                                        <path d="m5 9v6l7 4 7-4V9"></path>
                                        <path d="M12 13v6"></path>
                                    </svg>
                                </div>

                                <span class="rounded-full bg-white/80 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-blue-700">
                                    Recyclable
                                </span>
                            </div>

                            <div class="relative mt-5">
                                <h3 class="text-lg font-black text-slate-900">Anorganic</h3>
                                <p class="mt-1 text-xs font-medium text-slate-500">
                                    Plastic, glass, and metal
                                </p>
                            </div>

                        </div>

                        {{-- E-Waste --}}
                        <div class="group/card relative overflow-hidden rounded-[24px] border border-purple-200/80 bg-gradient-to-br from-purple-50 to-violet-100/80 p-5 transition duration-300 hover:-translate-y-1.5 hover:border-purple-300 hover:shadow-[0_18px_40px_rgba(168,85,247,0.22)]">

                            <div class="absolute -right-6 -top-6 h-20 w-20 rounded-full bg-purple-200/60 blur-xl transition duration-300 group-hover/card:scale-125"></div>

                            <div class="relative flex items-start justify-between">
                                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white text-purple-600 shadow-md shadow-purple-500/10 transition duration-300 group-hover/card:-rotate-3 group-hover/card:scale-110">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         viewBox="0 0 24 24"
                                         fill="none"
                                         stroke="currentColor"
                                         stroke-width="2"
                                         stroke-linecap="round"
                                         stroke-linejoin="round"
                                         class="h-6 w-6">
                                        <rect width="18" height="12" x="3" y="4" rx="2"></rect>
                                        <path d="M8 20h8"></path>
                                        <path d="M12 16v4"></path>
                                        <path d="M8 9h2"></path>
                                        <path d="M14 9h2"></path>
                                    </svg>
                                </div>

                                <span class="rounded-full bg-white/80 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-purple-700">
                                    Electronic
                                </span>
                            </div>

                            <div class="relative mt-5">
                                <h3 class="text-lg font-black text-slate-900">E-Waste</h3>
                                <p class="mt-1 text-xs font-medium text-slate-500">
                                    Electronic devices and parts
                                </p>
                            </div>

                        </div>

                        {{-- Residue --}}
                        <div class="group/card relative overflow-hidden rounded-[24px] border border-amber-200/80 bg-gradient-to-br from-amber-50 to-orange-100/80 p-5 transition duration-300 hover:-translate-y-1.5 hover:border-amber-300 hover:shadow-[0_18px_40px_rgba(245,158,11,0.22)]">

                            <div class="absolute -right-6 -top-6 h-20 w-20 rounded-full bg-amber-200/60 blur-xl transition duration-300 group-hover/card:scale-125"></div>

                            <div class="relative flex items-start justify-between">
                                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white text-amber-600 shadow-md shadow-amber-500/10 transition duration-300 group-hover/card:rotate-3 group-hover/card:scale-110">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         viewBox="0 0 24 24"
                                         fill="none"
                                         stroke="currentColor"
                                         stroke-width="2"
                                         stroke-linecap="round"
                                         stroke-linejoin="round"
                                         class="h-6 w-6">
                                        <path d="M3 6h18"></path>
                                        <path d="M8 6V4h8v2"></path>
                                        <path d="m19 6-1 14H6L5 6"></path>
                                        <path d="M10 11v5"></path>
                                        <path d="M14 11v5"></path>
                                    </svg>
                                </div>

                                <span class="rounded-full bg-white/80 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-amber-700">
                                    Residual
                                </span>
                            </div>

                            <div class="relative mt-5">
                                <h3 class="text-lg font-black text-slate-900">Residu</h3>
                                <p class="mt-1 text-xs font-medium text-slate-500">
                                    Non-recyclable remaining waste
                                </p>
                            </div>

                        </div>

                    </div>

                    <div class="relative mt-5 flex items-center justify-between rounded-2xl border border-slate-200 bg-white/80 px-4 py-3 shadow-sm">

                        <div class="flex items-center gap-3">
                            <div class="relative flex h-9 w-9 items-center justify-center rounded-xl bg-lime-100 text-lime-700">
                                <span class="absolute inset-0 animate-ping rounded-xl bg-lime-300 opacity-20"></span>
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 24 24"
                                     fill="none"
                                     stroke="currentColor"
                                     stroke-width="2"
                                     stroke-linecap="round"
                                     stroke-linejoin="round"
                                     class="relative h-4 w-4">
                                    <path d="M12 2a10 10 0 1 0 10 10"></path>
                                    <path d="m16 8-4.5 4.5L9 10"></path>
                                </svg>
                            </div>

                            <div>
                                <p class="text-sm font-bold text-slate-900">
                                    Ready to identify waste
                                </p>
                                <p class="text-xs text-slate-500">
                                    Upload or capture an image to begin
                                </p>
                            </div>
                        </div>

                        <span class="hidden rounded-full bg-lime-100 px-3 py-1 text-xs font-bold text-lime-700 sm:inline-flex">
                            Live
                        </span>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

{{-- PLATFORM HIGHLIGHTS --}}
<section class="relative overflow-hidden bg-white py-20">

    {{-- Decorative glow background --}}
    <div class="pointer-events-none absolute -left-28 top-10 h-72 w-72 rounded-full bg-lime-200/40 blur-3xl"></div>
    <div class="pointer-events-none absolute -right-28 bottom-0 h-72 w-72 rounded-full bg-green-200/30 blur-3xl"></div>

    <div class="relative max-w-7xl mx-auto px-6">

        <div class="mx-auto mb-12 max-w-3xl text-center">
            <div class="mb-4 inline-flex items-center gap-2 rounded-full border border-lime-200 bg-lime-50 px-4 py-2 text-xs font-bold uppercase tracking-[0.18em] text-lime-700">
                <span class="h-2 w-2 rounded-full bg-lime-500 shadow-[0_0_12px_rgba(132,204,22,0.85)]"></span>
                Karsa Nirmala in Numbers
            </div>

            <h2 class="text-3xl font-black tracking-tight text-slate-900 md:text-4xl">
                Intelligent Technology for Environmental Action
            </h2>

            <p class="mt-4 text-base leading-relaxed text-slate-500 md:text-lg">
                Karsa Nirmala combines image classification, artificial intelligence, and environmental education
                to help users identify and manage waste more responsibly.
            </p>
        </div>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">

            {{-- AI Accuracy --}}
            <div class="group relative">
                <div class="absolute -inset-1 rounded-[30px] bg-gradient-to-br from-lime-400/60 to-green-500/40 opacity-0 blur-xl transition duration-500 group-hover:opacity-100"></div>

                <div class="relative h-full overflow-hidden rounded-[28px] border border-slate-200 bg-white p-7 shadow-sm transition duration-300 group-hover:-translate-y-2 group-hover:border-lime-300 group-hover:shadow-2xl group-hover:shadow-lime-500/20">
                    <div class="absolute right-0 top-0 h-28 w-28 rounded-bl-full bg-lime-50 transition duration-300 group-hover:bg-lime-100"></div>

                    <div class="relative">
                        <div class="mb-7 flex items-center justify-between">
                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-lime-400 to-green-600 text-white shadow-lg shadow-lime-500/30">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6">
                                    <path d="M12 2a10 10 0 1 0 10 10"></path>
                                    <path d="m16 8-4.5 4.5L9 10"></path>
                                    <path d="M16 2v6h6"></path>
                                </svg>
                            </div>

                            <span class="rounded-full border border-lime-200 bg-lime-50 px-3 py-1 text-xs font-bold text-lime-700">
                                AI Model
                            </span>
                        </div>

                        <h3 class="text-4xl font-black tracking-tight text-lime-600 md:text-5xl">
                            Up to 90%
                        </h3>

                        <p class="mt-3 text-base font-black text-slate-900">
                            AI Accuracy
                        </p>

                        <p class="mt-2 text-sm leading-6 text-slate-500">
                            Image classification performance based on the model evaluation results.
                        </p>
                    </div>

                    <div class="absolute inset-x-0 bottom-0 h-1 bg-gradient-to-r from-lime-400 to-green-500"></div>
                </div>
            </div>

            {{-- Training Images --}}
            <div class="group relative">
                <div class="absolute -inset-1 rounded-[30px] bg-gradient-to-br from-cyan-400/50 to-blue-500/40 opacity-0 blur-xl transition duration-500 group-hover:opacity-100"></div>

                <div class="relative h-full overflow-hidden rounded-[28px] border border-slate-200 bg-white p-7 shadow-sm transition duration-300 group-hover:-translate-y-2 group-hover:border-blue-300 group-hover:shadow-2xl group-hover:shadow-blue-500/20">
                    <div class="absolute right-0 top-0 h-28 w-28 rounded-bl-full bg-blue-50 transition duration-300 group-hover:bg-blue-100"></div>

                    <div class="relative">
                        <div class="mb-7 flex items-center justify-between">
                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-cyan-400 to-blue-600 text-white shadow-lg shadow-blue-500/30">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6">
                                    <rect width="18" height="18" x="3" y="3" rx="2"></rect>
                                    <circle cx="9" cy="9" r="2"></circle>
                                    <path d="m21 15-3.5-3.5a2 2 0 0 0-2.8 0L6 20"></path>
                                </svg>
                            </div>

                            <span class="rounded-full border border-blue-200 bg-blue-50 px-3 py-1 text-xs font-bold text-blue-700">
                                Dataset
                            </span>
                        </div>

                        <h3 class="text-4xl font-black tracking-tight text-blue-600 md:text-5xl">
                            3K+
                        </h3>

                        <p class="mt-3 text-base font-black text-slate-900">
                            Training Images
                        </p>

                        <p class="mt-2 text-sm leading-6 text-slate-500">
                            Waste images used to train and evaluate the classification model.
                        </p>
                    </div>

                    <div class="absolute inset-x-0 bottom-0 h-1 bg-gradient-to-r from-cyan-400 to-blue-500"></div>
                </div>
            </div>

            {{-- Waste Categories --}}
            <div class="group relative">
                <div class="absolute -inset-1 rounded-[30px] bg-gradient-to-br from-amber-400/50 to-orange-500/40 opacity-0 blur-xl transition duration-500 group-hover:opacity-100"></div>

                <div class="relative h-full overflow-hidden rounded-[28px] border border-slate-200 bg-white p-7 shadow-sm transition duration-300 group-hover:-translate-y-2 group-hover:border-orange-300 group-hover:shadow-2xl group-hover:shadow-orange-500/20">
                    <div class="absolute right-0 top-0 h-28 w-28 rounded-bl-full bg-orange-50 transition duration-300 group-hover:bg-orange-100"></div>

                    <div class="relative">
                        <div class="mb-7 flex items-center justify-between">
                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-amber-400 to-orange-600 text-white shadow-lg shadow-orange-500/30">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6">
                                    <path d="M3 6h18"></path>
                                    <path d="M8 6V4h8v2"></path>
                                    <path d="m19 6-1 14H6L5 6"></path>
                                    <path d="M10 11v5"></path>
                                    <path d="M14 11v5"></path>
                                </svg>
                            </div>

                            <span class="rounded-full border border-orange-200 bg-orange-50 px-3 py-1 text-xs font-bold text-orange-700">
                                Categories
                            </span>
                        </div>

                        <h3 class="text-4xl font-black tracking-tight text-orange-600 md:text-5xl">
                            4
                        </h3>

                        <p class="mt-3 text-base font-black text-slate-900">
                            Waste Categories
                        </p>

                        <p class="mt-2 text-sm leading-6 text-slate-500">
                            Classification support for organic, inorganic, and electronic waste.
                        </p>
                    </div>

                    <div class="absolute inset-x-0 bottom-0 h-1 bg-gradient-to-r from-amber-400 to-orange-500"></div>
                </div>
            </div>

            {{-- AI Assistant --}}
            <div class="group relative">
                <div class="absolute -inset-1 rounded-[30px] bg-gradient-to-br from-fuchsia-400/50 to-purple-500/40 opacity-0 blur-xl transition duration-500 group-hover:opacity-100"></div>

                <div class="relative h-full overflow-hidden rounded-[28px] border border-slate-200 bg-white p-7 shadow-sm transition duration-300 group-hover:-translate-y-2 group-hover:border-purple-300 group-hover:shadow-2xl group-hover:shadow-purple-500/20">
                    <div class="absolute right-0 top-0 h-28 w-28 rounded-bl-full bg-purple-50 transition duration-300 group-hover:bg-purple-100"></div>

                    <div class="relative">
                        <div class="mb-7 flex items-center justify-between">
                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-fuchsia-400 to-purple-600 text-white shadow-lg shadow-purple-500/30">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6">
                                    <path d="M12 8V4H8"></path>
                                    <rect width="16" height="12" x="4" y="8" rx="2"></rect>
                                    <path d="M2 14h2"></path>
                                    <path d="M20 14h2"></path>
                                    <path d="M9 13v2"></path>
                                    <path d="M15 13v2"></path>
                                </svg>
                            </div>

                            <span class="rounded-full border border-purple-200 bg-purple-50 px-3 py-1 text-xs font-bold text-purple-700">
                                AI Assistant
                            </span>
                        </div>

                        <h3 class="text-4xl font-black tracking-tight text-purple-600 md:text-5xl">
                            24/7
                        </h3>

                        <p class="mt-3 text-base font-black text-slate-900">
                            Education Support
                        </p>

                        <p class="mt-2 text-sm leading-6 text-slate-500">
                            Ask questions about sorting, recycling, and sustainable waste management.
                        </p>
                    </div>

                    <div class="absolute inset-x-0 bottom-0 h-1 bg-gradient-to-r from-fuchsia-400 to-purple-500"></div>
                </div>
            </div>

        </div>

    </div>

</section>

{{-- CORE FEATURES --}}
<section id="features" class="relative overflow-hidden bg-slate-50 py-24">

    <div class="pointer-events-none absolute left-1/2 top-0 h-px w-full max-w-7xl -translate-x-1/2 bg-gradient-to-r from-transparent via-slate-300 to-transparent"></div>
    <div class="pointer-events-none absolute left-1/2 top-32 h-80 w-80 -translate-x-1/2 rounded-full bg-lime-100/60 blur-3xl"></div>

    <div class="relative max-w-7xl mx-auto px-6">

        <div class="mb-14 flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
            <div class="max-w-3xl">
                <div class="mb-4 inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-4 py-2 text-xs font-bold uppercase tracking-[0.18em] text-slate-600 shadow-sm">
                    <span class="h-2 w-2 rounded-full bg-lime-500 shadow-[0_0_12px_rgba(132,204,22,0.85)]"></span>
                    Core Features
                </div>

                <h2 class="text-4xl font-black tracking-tight text-slate-900 md:text-5xl">
                    Everything You Need to Identify and Manage Waste
                </h2>
            </div>

            <p class="max-w-md text-base leading-relaxed text-slate-500 lg:text-right">
                Every WISE feature supports one connected workflow, from waste identification
                to practical environmental education.
            </p>
        </div>

        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">

            {{-- AI Waste Scanner --}}
            <article class="group relative">
                <div class="absolute -inset-1 rounded-[32px] bg-gradient-to-br from-lime-400/70 to-green-500/40 opacity-0 blur-xl transition duration-500 group-hover:opacity-100"></div>

                <div class="relative flex min-h-[360px] h-full flex-col overflow-hidden rounded-[30px] border border-slate-200 bg-white p-7 shadow-sm transition duration-300 group-hover:-translate-y-2 group-hover:border-lime-300 group-hover:shadow-2xl group-hover:shadow-lime-500/20">
                    <div class="absolute -right-10 -top-10 h-32 w-32 rounded-full bg-lime-100 opacity-60 transition duration-500 group-hover:scale-125 group-hover:opacity-100"></div>

                    <div class="relative flex items-start justify-between">
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-lime-400 to-green-600 text-white shadow-lg shadow-lime-500/30 transition duration-300 group-hover:rotate-3 group-hover:scale-110">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-7 w-7">
                                <path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"></path>
                                <circle cx="12" cy="13" r="3"></circle>
                            </svg>
                        </div>

                        <span class="text-sm font-black text-slate-300 transition duration-300 group-hover:text-lime-500">
                            01
                        </span>
                    </div>

                    <div class="relative mt-8">
                        <span class="inline-flex rounded-full border border-lime-200 bg-lime-50 px-3 py-1 text-xs font-bold text-lime-700">
                            MobileNetV2
                        </span>

                        <h3 class="mt-4 text-xl font-black leading-snug text-slate-900 transition duration-300 group-hover:text-lime-700">
                            AI Waste Scanner
                        </h3>

                        <p class="mt-4 text-sm leading-7 text-slate-500">
                            Upload an image or use the camera to identify waste types automatically
                            through an image classification model.
                        </p>
                    </div>

                    <div class="relative mt-auto flex items-center gap-2 pt-8 text-sm font-bold text-lime-700">
                        <span>Image classification</span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1">
                            <path d="M5 12h14"></path>
                            <path d="m13 6 6 6-6 6"></path>
                        </svg>
                    </div>
                </div>
            </article>

            {{-- WISE AI Assistant --}}
            <article class="group relative">
                <div class="absolute -inset-1 rounded-[32px] bg-gradient-to-br from-fuchsia-400/60 to-purple-500/40 opacity-0 blur-xl transition duration-500 group-hover:opacity-100"></div>

                <div class="relative flex min-h-[360px] h-full flex-col overflow-hidden rounded-[30px] border border-slate-200 bg-white p-7 shadow-sm transition duration-300 group-hover:-translate-y-2 group-hover:border-purple-300 group-hover:shadow-2xl group-hover:shadow-purple-500/20">
                    <div class="absolute -right-10 -top-10 h-32 w-32 rounded-full bg-purple-100 opacity-60 transition duration-500 group-hover:scale-125 group-hover:opacity-100"></div>

                    <div class="relative flex items-start justify-between">
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-fuchsia-400 to-purple-600 text-white shadow-lg shadow-purple-500/30 transition duration-300 group-hover:-rotate-3 group-hover:scale-110">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-7 w-7">
                                <path d="M12 8V4H8"></path>
                                <rect width="16" height="12" x="4" y="8" rx="2"></rect>
                                <path d="M2 14h2"></path>
                                <path d="M20 14h2"></path>
                                <path d="M9 13v2"></path>
                                <path d="M15 13v2"></path>
                            </svg>
                        </div>

                        <span class="text-sm font-black text-slate-300 transition duration-300 group-hover:text-purple-500">
                            02
                        </span>
                    </div>

                    <div class="relative mt-8">
                        <span class="inline-flex rounded-full border border-purple-200 bg-purple-50 px-3 py-1 text-xs font-bold text-purple-700">
                            Google Gemma 4
                        </span>

                        <h3 class="mt-4 text-xl font-black leading-snug text-slate-900 transition duration-300 group-hover:text-purple-700">
                            WISE AI Assistant
                        </h3>

                        <p class="mt-4 text-sm leading-7 text-slate-500">
                            Receive educational answers about waste sorting, recycling,
                            reuse, and responsible disposal methods.
                        </p>
                    </div>

                    <div class="relative mt-auto flex items-center gap-2 pt-8 text-sm font-bold text-purple-700">
                        <span>Interactive assistance</span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1">
                            <path d="M5 12h14"></path>
                            <path d="m13 6 6 6-6 6"></path>
                        </svg>
                    </div>
                </div>
            </article>

            {{-- Waste Education --}}
            <article class="group relative">
                <div class="absolute -inset-1 rounded-[32px] bg-gradient-to-br from-cyan-400/60 to-blue-500/40 opacity-0 blur-xl transition duration-500 group-hover:opacity-100"></div>

                <div class="relative flex min-h-[360px] h-full flex-col overflow-hidden rounded-[30px] border border-slate-200 bg-white p-7 shadow-sm transition duration-300 group-hover:-translate-y-2 group-hover:border-blue-300 group-hover:shadow-2xl group-hover:shadow-blue-500/20">
                    <div class="absolute -right-10 -top-10 h-32 w-32 rounded-full bg-blue-100 opacity-60 transition duration-500 group-hover:scale-125 group-hover:opacity-100"></div>

                    <div class="relative flex items-start justify-between">
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-cyan-400 to-blue-600 text-white shadow-lg shadow-blue-500/30 transition duration-300 group-hover:rotate-3 group-hover:scale-110">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-7 w-7">
                                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                            </svg>
                        </div>

                        <span class="text-sm font-black text-slate-300 transition duration-300 group-hover:text-blue-500">
                            03
                        </span>
                    </div>

                    <div class="relative mt-8">
                        <span class="inline-flex rounded-full border border-blue-200 bg-blue-50 px-3 py-1 text-xs font-bold text-blue-700">
                            Education
                        </span>

                        <h3 class="mt-4 text-xl font-black leading-snug text-slate-900 transition duration-300 group-hover:text-blue-700">
                            Waste Education
                        </h3>

                        <p class="mt-4 text-sm leading-7 text-slate-500">
                            Learn proper waste management methods 
                            and gain information on the economic value of recyclable waste.
                        </p>
                    </div>

                    <div class="relative mt-auto flex items-center gap-2 pt-8 text-sm font-bold text-blue-700">
                        <span>Environmental learning</span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1">
                            <path d="M5 12h14"></path>
                            <path d="m13 6 6 6-6 6"></path>
                        </svg>
                    </div>
                </div>
            </article>

            {{-- Geographic Integration System --}}
            <article class="group relative">
                <div class="absolute -inset-1 rounded-[32px] bg-gradient-to-br from-amber-400/60 to-orange-500/40 opacity-0 blur-xl transition duration-500 group-hover:opacity-100"></div>

                <div class="relative flex min-h-[360px] h-full flex-col overflow-hidden rounded-[30px] border border-slate-200 bg-white p-7 shadow-sm transition duration-300 group-hover:-translate-y-2 group-hover:border-orange-300 group-hover:shadow-2xl group-hover:shadow-orange-500/20">
                    <div class="absolute -right-10 -top-10 h-32 w-32 rounded-full bg-orange-100 opacity-60 transition duration-500 group-hover:scale-125 group-hover:opacity-100"></div>

                    <div class="relative flex items-start justify-between">
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-amber-400 to-orange-600 text-white shadow-lg shadow-orange-500/30 transition duration-300 group-hover:-rotate-3 group-hover:scale-110">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-7 w-7">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                        </div>

                        <span class="text-sm font-black text-slate-300 transition duration-300 group-hover:text-orange-500">
                            04
                        </span>
                    </div>

                    <div class="relative mt-8">
                        <span class="inline-flex rounded-full border border-orange-200 bg-orange-50 px-3 py-1 text-xs font-bold text-orange-700">
                            Geo Map
                        </span>

                        <h3 class="mt-4 text-xl font-black leading-snug text-slate-900 transition duration-300 group-hover:text-orange-700">
                            Geographic Integration System
                        </h3>

                        <p class="mt-4 text-sm leading-7 text-slate-500">
                            Find the nearest waste processing facility based on the type of waste.
                        </p>
                    </div>

                    <div class="relative mt-auto flex items-center gap-2 pt-8 text-sm font-bold text-orange-700">
                        <span>Scan statistics</span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1">
                            <path d="M5 12h14"></path>
                            <path d="m13 6 6 6-6 6"></path>
                        </svg>
                    </div>
                </div>
            </article>

        </div>

        <div class="mt-10 flex flex-wrap items-center justify-center gap-3">
            <span class="rounded-full border border-slate-200 bg-white px-4 py-2 text-xs font-semibold text-slate-500 shadow-sm">
                Camera and image upload
            </span>

            <span class="rounded-full border border-slate-200 bg-white px-4 py-2 text-xs font-semibold text-slate-500 shadow-sm">
                Instant prediction
            </span>

            <span class="rounded-full border border-slate-200 bg-white px-4 py-2 text-xs font-semibold text-slate-500 shadow-sm">
                Recycling recommendations
            </span>

            <span class="rounded-full border border-slate-200 bg-white px-4 py-2 text-xs font-semibold text-slate-500 shadow-sm">
                Economic value insights
            </span>
        </div>

    </div>

</section>

<footer class="bg-slate-900 text-white py-20">

<div class="max-w-7xl mx-auto px-6 text-center">

<h2 class="text-4xl font-black">
Smart Waste AI Classification
</h2>

<p class="mt-6 text-slate-400">
        Karsa Nirmala —  Sistem Cerdas Pengelolaan Sampah | Ekonomi Sirkular

</div>

</footer>

@endsection