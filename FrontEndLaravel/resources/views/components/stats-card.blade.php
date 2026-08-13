@props([
    'title',
    'value',
    'icon',
    'color' => 'lime'
])

@php
    $accentClass = match ($color) {
        'lime' => 'bg-lime-100 text-lime-700',
        'green' => 'bg-green-100 text-green-700',
        'emerald' => 'bg-emerald-100 text-emerald-700',
        'sky' => 'bg-sky-100 text-sky-700',
        default => 'bg-lime-100 text-lime-700',
    };
@endphp

<div class="hover-lift group bg-white/85 rounded-[28px] border border-slate-200/80 p-5 shadow-[0_18px_45px_rgba(15,23,42,0.06)] animate-card-enter">

    <div class="flex items-start justify-between gap-4">

        <div class="space-y-3">

            <p class="text-slate-500 text-sm font-semibold tracking-wide uppercase">
                {{ $title }}
            </p>

            <h3 class="text-4xl font-black leading-none text-slate-800">
                {{ $value }}
            </h3>

        </div>

        <div class="w-16 h-16 rounded-2xl flex items-center justify-center {{ $accentClass }} text-2xl shadow-inner ring-1 ring-white/70">
            {{ $icon }}
        </div>

    </div>

</div>