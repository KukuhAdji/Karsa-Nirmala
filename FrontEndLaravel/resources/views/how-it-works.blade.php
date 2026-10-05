@extends('layouts.guest')

@section('content')
    <nav class="fixed inset-x-0 top-0 z-50 border-b border-slate-200/80 bg-white/90 backdrop-blur-xl">
        <div class="mx-auto flex h-20 max-w-7xl items-center justify-between px-6">
            <a href="{{ route('landing') }}" class="group flex items-center gap-3" aria-label="Karsa Nirmala Home">
                <img
                    src="{{ asset('images/karsa-nirmala-logo.png') }}"
                    alt="Karsa Nirmala logo"
                    class="h-14 w-14 object-contain">
                <span class="text-lg font-black tracking-tight text-slate-900 transition group-hover:text-lime-700 sm:text-xl">
                    Karsa Nirmala
                </span>
            </a>

            <a href="{{ route('login') }}"
               class="inline-flex h-11 items-center gap-2 rounded-xl bg-gradient-to-r from-lime-500 to-green-600 px-5 text-sm font-bold text-white shadow-lg shadow-lime-500/20 transition hover:-translate-y-0.5 hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-lime-200">
                Mulai Sekarang
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4" aria-hidden="true">
                    <path d="M5 12h14"></path>
                    <path d="m13 6 6 6-6 6"></path>
                </svg>
            </a>
        </div>
    </nav>

    <main>
        <section class="relative overflow-hidden bg-gradient-to-b from-lime-50 via-white to-white pb-20 pt-36 sm:pb-28">
            <div class="pointer-events-none absolute -left-32 top-16 h-96 w-96 rounded-full bg-lime-200/40 blur-3xl"></div>
            <div class="pointer-events-none absolute -right-32 top-24 h-96 w-96 rounded-full bg-emerald-200/30 blur-3xl"></div>
            <div class="pointer-events-none absolute inset-0 opacity-[0.035]" style="background-image: radial-gradient(#65a30d 1px, transparent 1px); background-size: 28px 28px;"></div>

            <div class="relative mx-auto max-w-7xl px-6">
                <div class="mx-auto max-w-3xl text-center">
                    <span class="inline-flex items-center gap-2 rounded-full border border-lime-200 bg-white/80 px-4 py-2 text-xs font-bold uppercase tracking-[0.18em] text-lime-700 shadow-sm">
                        <span class="h-2 w-2 rounded-full bg-lime-500"></span>
                        Cara Kerja Karsa Nirmala
                    </span>
                    <h1 class="mt-6 text-4xl font-black leading-tight tracking-tight text-slate-900 sm:text-5xl md:text-6xl">
                        Dari kenali sampah hingga
                        <span class="bg-gradient-to-r from-lime-500 to-green-600 bg-clip-text text-transparent">ambil tindakan.</span>
                    </h1>
                    <p class="mx-auto mt-6 max-w-2xl text-base leading-7 text-slate-500 sm:text-lg sm:leading-8">
                        Ikuti alur sederhana untuk mengidentifikasi sampah, memahami rekomendasi pengelolaannya, dan menyimpan hasil scan Anda.
                    </p>
                </div>

                <div class="relative mx-auto mt-14 max-w-5xl">
                    <div class="absolute left-[10%] right-[10%] top-8 hidden h-px bg-gradient-to-r from-lime-300 via-green-300 to-emerald-300 md:block"></div>
                    <div class="grid gap-5 md:grid-cols-3">
                        <article class="relative rounded-[28px] border border-slate-200 bg-white/90 p-6 shadow-sm transition duration-300 hover:-translate-y-1 hover:border-lime-300 hover:shadow-xl hover:shadow-lime-500/10">
                            <div class="relative z-10 flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-lime-400 to-green-600 text-2xl font-black text-white shadow-lg shadow-lime-500/25">01</div>
                            <h2 class="mt-6 text-xl font-black text-slate-900">Ambil atau unggah foto</h2>
                            <p class="mt-3 text-sm leading-7 text-slate-500">Masuk ke Scanner, lalu gunakan kamera atau pilih foto sampah dari perangkat Anda.</p>
                        </article>

                        <article class="relative rounded-[28px] border border-slate-200 bg-white/90 p-6 shadow-sm transition duration-300 hover:-translate-y-1 hover:border-lime-300 hover:shadow-xl hover:shadow-lime-500/10">
                            <div class="relative z-10 flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-lime-400 to-green-600 text-2xl font-black text-white shadow-lg shadow-lime-500/25">02</div>
                            <h2 class="mt-6 text-xl font-black text-slate-900">AI mengenali sampah</h2>
                            <p class="mt-3 text-sm leading-7 text-slate-500">Sistem menganalisis gambar dan menampilkan kategori sampah beserta tingkat keyakinan hasil klasifikasi.</p>
                        </article>

                        <article class="relative rounded-[28px] border border-slate-200 bg-white/90 p-6 shadow-sm transition duration-300 hover:-translate-y-1 hover:border-lime-300 hover:shadow-xl hover:shadow-lime-500/10">
                            <div class="relative z-10 flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-lime-400 to-green-600 text-2xl font-black text-white shadow-lg shadow-lime-500/25">03</div>
                            <h2 class="mt-6 text-xl font-black text-slate-900">Pahami rekomendasi</h2>
                            <p class="mt-3 text-sm leading-7 text-slate-500">Baca saran pengelolaan yang ditampilkan agar Anda tahu langkah berikutnya untuk sampah tersebut.</p>
                        </article>
                    </div>
                </div>
            </div>
        </section>

        <section class="relative overflow-hidden bg-slate-50 py-20 sm:py-24">
            <div class="pointer-events-none absolute -right-24 top-12 h-72 w-72 rounded-full bg-lime-100/70 blur-3xl"></div>
            <div class="relative mx-auto grid max-w-7xl items-center gap-12 px-6 lg:grid-cols-[0.9fr_1.1fr]">
                <div>
                    <span class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-4 py-2 text-xs font-bold uppercase tracking-[0.18em] text-slate-600 shadow-sm">
                        Hasil yang tersimpan
                    </span>
                    <h2 class="mt-5 text-3xl font-black tracking-tight text-slate-900 sm:text-4xl">
                        Satu scan, panduan yang bisa dibuka kembali.
                    </h2>
                    <p class="mt-5 text-base leading-7 text-slate-500">
                        Simpan hasil klasifikasi ke akun Anda. Kapan pun diperlukan, kunjungi Riwayat Scan untuk melihat kembali foto, kategori, tingkat keyakinan, dan rekomendasi.
                    </p>
                    <a href="{{ route('login') }}"
                       class="mt-8 inline-flex h-12 items-center gap-2 rounded-xl bg-gradient-to-r from-lime-500 to-green-600 px-5 text-sm font-bold text-white shadow-lg shadow-lime-500/20 transition hover:-translate-y-0.5 hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-lime-200">
                        Coba Scanner
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4" aria-hidden="true">
                            <path d="M5 12h14"></path>
                            <path d="m13 6 6 6-6 6"></path>
                        </svg>
                    </a>
                </div>

                <div class="rounded-[32px] border border-slate-200 bg-white p-6 shadow-[0_24px_80px_rgba(15,23,42,0.08)] sm:p-8">
                    <div class="flex items-center gap-4 border-b border-slate-100 pb-6">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-lime-100 text-lime-700">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6" aria-hidden="true">
                                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-lime-700">Perjalanan Anda</p>
                            <p class="mt-1 text-lg font-black text-slate-900">Kenali · Pahami · Kelola</p>
                        </div>
                    </div>

                    <ol class="mt-6 space-y-5">
                        <li class="flex gap-4">
                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-lime-100 text-sm font-black text-lime-700">1</span>
                            <div>
                                <h3 class="font-bold text-slate-900">Hasil scan tersimpan di Riwayat</h3>
                                <p class="mt-1 text-sm leading-6 text-slate-500">Buka detail hasil kapan saja setelah scan berhasil disimpan.</p>
                            </div>
                        </li>
                        <li class="flex gap-4">
                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-lime-100 text-sm font-black text-lime-700">2</span>
                            <div>
                                <h3 class="font-bold text-slate-900">Cari informasi atau bantuan</h3>
                                <p class="mt-1 text-sm leading-6 text-slate-500">Gunakan asisten Peri Nirmala untuk mempelajari pengelolaan sampah.</p>
                            </div>
                        </li>
                        <li class="flex gap-4">
                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-lime-100 text-sm font-black text-lime-700">3</span>
                            <div>
                                <h3 class="font-bold text-slate-900">Lanjutkan ke aksi yang sesuai</h3>
                                <p class="mt-1 text-sm leading-6 text-slate-500">Jelajahi Bank Sampah dan Marketplace untuk menemukan pilihan pengelolaan atau pemanfaatan berikutnya.</p>
                            </div>
                        </li>
                    </ol>
                </div>
            </div>
        </section>

        <section class="bg-white px-6 py-16">
            <div class="mx-auto flex max-w-5xl flex-col items-center justify-between gap-6 rounded-[32px] bg-gradient-to-r from-lime-500 to-green-600 p-8 text-center shadow-xl shadow-lime-500/15 sm:flex-row sm:p-10 sm:text-left">
                <div>
                    <h2 class="text-2xl font-black text-white sm:text-3xl">Mulai dari satu sampah.</h2>
                    <p class="mt-2 text-sm leading-6 text-lime-50 sm:text-base">Kenali jenisnya dan temukan cara mengelolanya dengan lebih bijak.</p>
                </div>
                <a href="{{ route('login') }}" class="inline-flex h-12 shrink-0 items-center gap-2 rounded-xl bg-white px-5 text-sm font-bold text-green-700 shadow-sm transition hover:-translate-y-0.5 hover:bg-lime-50 focus:outline-none focus:ring-4 focus:ring-white/40">
                    Mulai Scan
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4" aria-hidden="true">
                        <path d="M5 12h14"></path>
                        <path d="m13 6 6 6-6 6"></path>
                    </svg>
                </a>
            </div>
        </section>
    </main>
@endsection
