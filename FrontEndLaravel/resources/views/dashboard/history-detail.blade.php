@extends('layouts.app')

@section('content')
    @php
        $storagePath = storage_path('app/public/' . ($classification->image ?? ''));
        $imageUrl = $classification->image && file_exists($storagePath)
            ? asset('storage/' . $classification->image)
            : asset('images/karsa-nirmala-logo.png');
    @endphp

    <div class="mx-auto max-w-4xl space-y-6">
        <a
            href="{{ route('scanner.history') }}"
            class="inline-flex items-center gap-2 text-sm font-bold text-lime-700 transition hover:text-lime-800">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="m15 18-6-6 6-6"/>
                <path d="M9 12h12"/>
            </svg>
            Kembali ke Riwayat Scan
        </a>

        <div>
            <h1 class="text-3xl font-black text-slate-900">Detail Hasil Scan</h1>
            <p class="mt-2 text-slate-500">Informasi lengkap hasil klasifikasi sampah Anda</p>
        </div>

        <article class="overflow-hidden rounded-[24px] border border-slate-200/80 bg-white/90 shadow-sm">
            <div class="relative h-64 bg-slate-100 sm:h-96">
                <img
                    src="{{ $imageUrl }}"
                    alt="Gambar hasil scan {{ $classification->category }}"
                    class="h-full w-full object-contain">
                <span class="absolute right-4 top-4 rounded-full bg-gradient-to-r from-lime-400 to-green-500 px-3 py-1.5 text-sm font-bold text-white shadow-md">
                    {{ number_format($classification->confidence, 0) }}% keyakinan
                </span>
            </div>

            <div class="space-y-6 p-5 sm:p-8">
                <div class="grid gap-5 sm:grid-cols-2">
                    <section>
                        <h2 class="text-xs font-bold uppercase tracking-wide text-slate-500">Kategori</h2>
                        <p class="mt-2 inline-flex rounded-full border border-lime-200/50 bg-lime-50 px-3 py-1 text-sm font-bold text-lime-700">
                            {{ ucfirst($classification->category) }}
                        </p>
                    </section>
                    <section>
                        <h2 class="text-xs font-bold uppercase tracking-wide text-slate-500">Waktu Scan</h2>
                        <p class="mt-2 text-sm font-semibold text-slate-800">
                            {{ $classification->created_at->format('d M Y, H:i') }}
                        </p>
                    </section>
                </div>

                <section>
                    <h2 class="text-xs font-bold uppercase tracking-wide text-slate-500">Rekomendasi Pengelolaan</h2>
                    <p class="mt-2 whitespace-pre-line text-sm leading-6 text-slate-700">
                        {{ $classification->recommendation ?: 'Belum ada rekomendasi untuk hasil scan ini.' }}
                    </p>
                </section>
            </div>
        </article>
    </div>
@endsection
