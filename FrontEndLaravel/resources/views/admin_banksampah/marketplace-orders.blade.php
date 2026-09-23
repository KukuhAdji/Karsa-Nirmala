@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-6xl space-y-6">
        <div class="flex flex-col justify-between gap-3 sm:flex-row sm:items-end">
            <div>
                <p class="text-sm font-semibold uppercase tracking-wide text-emerald-600">Admin Bank Sampah</p>
                <h1 class="mt-1 text-3xl font-black text-slate-900">Form Pembelian Marketplace</h1>
                <p class="mt-2 text-sm text-slate-500">Pesanan yang masuk ke {{ $bankSampah->name }}.</p>
            </div>
            <a href="{{ route('admin.bank-sampah.catalog.index') }}" class="rounded-2xl border border-emerald-200 px-4 py-2 text-sm font-bold text-emerald-700 hover:bg-emerald-50">← Kembali ke Marketplace</a>
        </div>

        @if (session('success'))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">{{ $errors->first() }}</div>
        @endif

        @forelse ($orders as $order)
            <section class="rounded-[28px] border border-slate-200 bg-white p-5 shadow-sm sm:p-7">
                <div class="flex flex-col justify-between gap-2 sm:flex-row">
                    <div>
                        <h2 class="text-lg font-black text-slate-900">{{ $order->product->name }}</h2>
                        <p class="mt-1 text-sm text-slate-500">Dikirim {{ $order->created_at->format('d M Y, H:i') }} oleh {{ $order->customer_name }} ({{ $order->customer_phone }})</p>
                    </div>
                    <span class="h-fit rounded-full bg-amber-50 px-3 py-1 text-xs font-bold text-amber-700">{{ $order->status }}</span>
                </div>
                <div class="mt-5 grid gap-4 text-sm md:grid-cols-3">
                    <div><p class="text-slate-500">Jumlah / Total</p><p class="mt-1 font-black text-slate-800">{{ $order->quantity }} × Rp {{ number_format($order->unit_price, 0, ',', '.') }} = Rp {{ number_format($order->total_price, 0, ',', '.') }}</p></div>
                    <div><p class="text-slate-500">Alamat pengiriman</p><p class="mt-1 font-semibold text-slate-800">{{ $order->shipping_address }}</p></div>
                    <div>
                        <p class="text-slate-500">Bukti pembayaran</p>
                        @if ($order->payment_proof)
                            <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank" class="mt-1 inline-flex font-bold text-emerald-700 hover:underline">Lihat bukti pembayaran ↗</a>
                            @if ($order->status !== 'Pembayaran dikonfirmasi')
                                <form method="POST" action="{{ route('admin.bank-sampah.orders.confirm-payment', $order) }}" class="mt-3">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="rounded-xl bg-emerald-600 px-4 py-2 text-xs font-bold text-white hover:bg-emerald-700" onclick="return confirm('Konfirmasi pembayaran pesanan ini?')">Konfirmasi Pembayaran</button>
                                </form>
                            @else
                                <p class="mt-3 text-xs font-bold text-emerald-700">Pembayaran sudah dikonfirmasi.</p>
                            @endif
                        @else
                            <p class="mt-1 font-semibold text-slate-400">Belum diunggah</p>
                        @endif
                    </div>
                </div>
            </section>
        @empty
            <div class="rounded-[28px] border border-dashed border-slate-300 bg-white p-8 text-center text-sm text-slate-500">Belum ada form pembelian dari user.</div>
        @endforelse
    </div>
@endsection
