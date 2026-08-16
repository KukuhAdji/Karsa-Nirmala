@extends('layouts.app')

@section('content')

<div class="space-y-6">

    <div class="dashboard-shell rounded-[32px] bg-gradient-to-r from-lime-500 via-lime-500 to-green-600 p-8 md:p-10 text-white shadow-[0_28px_70px_rgba(34,197,94,0.25)]">

        <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">

            <div class="relative z-10">
                <p class="inline-flex items-center rounded-full border border-white/35 bg-white/10 px-3 py-1.5 text-xs font-bold uppercase tracking-[0.2em] text-lime-50/90 backdrop-blur-sm">
                    Dashboard
                </p>
                <h1 class="mt-5 text-4xl font-black leading-tight md:text-5xl">
                    Sugeng Rawuh, {{ Auth::user()->name ?? 'User' }}!
                </h1>
                <p class="mt-4 max-w-2xl text-base text-lime-50/90 md:text-lg">
                    Memayu Hayuning Bawana.
                </p>
            </div>

            <div class="relative z-10 flex h-24 w-24 items-center justify-center rounded-[28px] border border-white/25 bg-white/10 text-5xl shadow-inner backdrop-blur-sm lg:h-28 lg:w-28">
                ♻️
            </div>

        </div>

    </div>

    <div class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-4">

        <x-stats-card
            title="Total Scans"
            value="{{ number_format($totalScans) }}"
            icon="📸"
            color="lime" />

        <x-stats-card
            title="Anorganic Waste"
            value="{{ number_format($anorganic) }}"
            icon="🧴"
            color="green" />

        <x-stats-card
            title="Organic Waste"
            value="{{ number_format($organic) }}"
            icon="🍃"
            color="emerald" />

        <x-stats-card
            title="E-Waste"
            value="{{ number_format($ewaste) }}"
            icon="💻"
            color="sky" />

    </div>

    <div class="grid gap-6 lg:grid-cols-2">

        <x-chart-card title="Classification Trend" :showAction="false">

            <div class="h-72">
                <canvas id="trendChart"></canvas>
            </div>

        </x-chart-card>

        <x-chart-card title="Waste Distribution">

            <div class="h-72">
                <canvas id="distributionChart"></canvas>
            </div>

        </x-chart-card>

    </div>

    <div class="rounded-[30px] border border-slate-200/80 bg-white/85 p-5 shadow-[0_18px_45px_rgba(15,23,42,0.05)]">

        <div class="mb-5 flex items-center justify-between">
            <h3 class="text-2xl font-black text-slate-800">Recent Scans</h3>
            <span class="rounded-full bg-lime-50 px-3 py-1 text-xs font-bold uppercase tracking-wide text-lime-700">Live</span>
        </div>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            @forelse($recentActivities as $activity)
                @php
                    $storagePath = storage_path('app/public/' . ($activity->image ?? ''));
                    if (!empty($activity->image) && file_exists($storagePath)) {
                        $img = asset('storage/' . $activity->image);
                    } else {
                        $img = asset('images/placeholder.png');
                    }
                @endphp

                <div class="hover-lift flex flex-col overflow-hidden rounded-[24px] border border-slate-200 bg-slate-50/80 shadow-sm">
                    <img src="{{ $img }}" alt="scan" class="h-36 w-full object-cover" />
                    <div class="p-4">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <h4 class="font-black text-slate-800">{{ $activity->category }}</h4>
                                <p class="text-sm text-slate-500">{{ $activity->created_at->diffForHumans() }}</p>
                            </div>
                            <div class="rounded-full bg-lime-100 px-2.5 py-1 text-xs font-bold text-lime-700">
                                {{ number_format($activity->confidence, 1) }}%
                            </div>
                        </div>
                    </div>
                </div>

            @empty
                <div class="col-span-full rounded-[24px] border border-dashed border-slate-300 bg-slate-50 p-8 text-center text-slate-500">
                    No recent scans yet.
                </div>
            @endforelse
        </div>

    </div>

</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
    new Chart(document.getElementById('trendChart'), {
        type: 'line',
        data: {
            labels: @json($trendLabels),
            datasets: [{
                label: 'Scans per Day',
                data: @json($trendValues),
                borderColor: '#65a30d',
                backgroundColor: 'rgba(101, 163, 13, 0.15)',
                tension: 0.35,
                fill: true,
                borderWidth: 3,
                pointRadius: 0,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: { display: false }
            },
            animation: {
                duration: 1200,
                easing: 'easeOutBack',
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { color: '#64748b' }
                },
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0, color: '#64748b' },
                    grid: { color: 'rgba(148, 163, 184, 0.15)' }
                }
            }
        }
    });

    new Chart(document.getElementById('distributionChart'), {
        type: 'doughnut',
        data: {
            labels: @json($distributionLabels),
            datasets: [{
                data: @json($distributionValues),
                backgroundColor: ['#3b82f6', '#22c55e', '#f59e0b'],
                borderWidth: 0,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '60%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        pointStyle: 'circle',
                        boxWidth: 8,
                        padding: 20,
                        color: '#334155'
                    }
                }
            },
            animation: {
                duration: 1200,
                easing: 'easeOutBack',
            },
        }
    });
</script>
@endpush

@endsection
