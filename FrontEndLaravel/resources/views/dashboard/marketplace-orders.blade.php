@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-5xl space-y-6">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <h1 class="text-3xl font-black text-slate-900">Pesanan Saya</h1>
                <p class="mt-2 text-slate-500">Lihat status dan detail pesanan marketplace Anda.</p>
            </div>
            <a href="{{ route('marketplace') }}" class="inline-flex items-center rounded-xl border border-emerald-200 bg-white px-4 py-2.5 text-sm font-bold text-emerald-700 transition hover:bg-emerald-50">
                ← Kembali ke Marketplace
            </a>
        </div>

        @forelse ($orders as $order)
            <article class="rounded-[24px] border border-slate-200 bg-white p-5 shadow-sm md:p-6">
                <div class="flex flex-wrap items-start justify-between gap-3">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wide text-slate-400">Pesanan #{{ $order->id }}</p>
                        <h2 class="mt-1 text-lg font-black text-slate-900">{{ $order->product->name }}</h2>
                        <p class="mt-1 text-sm text-slate-500">
                            {{ $order->product->bankSampah?->name ?? 'Bank Sampah' }}
                            <span class="px-1">·</span>
                            {{ $order->created_at->format('d M Y, H:i') }}
                        </p>
                    </div>
                    <span class="inline-flex rounded-full bg-amber-50 px-3 py-1.5 text-xs font-bold text-amber-800">
                        {{ $order->status }}
                    </span>
                </div>

                <dl class="mt-5 grid gap-4 border-t border-slate-100 pt-4 text-sm sm:grid-cols-2 lg:grid-cols-3">
                    <div>
                        <dt class="text-slate-500">Jumlah</dt>
                        <dd class="mt-1 font-bold text-slate-800">{{ $order->quantity }} produk</dd>
                    </div>
                    <div>
                        <dt class="text-slate-500">Total</dt>
                        <dd class="mt-1 font-black text-lime-700">Rp {{ number_format($order->total_price, 0, ',', '.') }}</dd>
                    </div>
                    <div class="sm:col-span-2 lg:col-span-1">
                        <dt class="text-slate-500">Bukti pembayaran</dt>
                        <dd class="mt-1 font-bold {{ $order->payment_proof ? 'text-emerald-700' : 'text-slate-500' }}">
                            {{ $order->payment_proof ? 'Sudah dikirim' : 'Belum dikirim' }}
                        </dd>
                    </div>
                </dl>

                <a href="{{ route('marketplace.payment', $order) }}" class="mt-5 inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-lime-500 to-green-600 px-4 py-2.5 text-sm font-bold text-white transition hover:shadow-lg">
                    Lihat detail pesanan
                </a>
            </article>
        @empty
            <div class="rounded-[24px] border border-dashed border-slate-300 bg-white p-10 text-center">
                <h2 class="text-lg font-black text-slate-800">Belum ada pesanan</h2>
                <p class="mt-2 text-sm text-slate-500">Pesanan yang Anda buat akan muncul di halaman ini.</p>
                <a href="{{ route('marketplace') }}" class="mt-5 inline-flex rounded-xl bg-lime-500 px-4 py-2.5 text-sm font-bold text-white transition hover:bg-lime-600">
                    Lihat produk
                </a>
            </div>
        @endforelse
    </div>
@endsection
