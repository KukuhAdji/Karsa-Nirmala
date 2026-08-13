@props([
    'title',
    'showAction' => true,
])

<div class="hover-lift bg-white/85 rounded-[30px] border border-slate-200/80 p-5 shadow-[0_18px_45px_rgba(15,23,42,0.05)] animate-chart-appear">

    <div class="flex justify-between items-center mb-5">

        <h3 class="text-2xl font-black text-slate-800">
            {{ $title }}
        </h3>

        @if($showAction)
            <button class="text-sm font-bold text-lime-700 bg-lime-50 border border-lime-200 px-3 py-1.5 rounded-full">
                View More
            </button>
        @endif

    </div>

    {{ $slot }}

</div>