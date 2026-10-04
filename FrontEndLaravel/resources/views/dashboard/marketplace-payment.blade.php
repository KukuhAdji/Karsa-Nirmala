@extends('layouts.app')

@section('content')
    @if ($order->payment_proof)
        <div class="mx-auto flex min-h-[60vh] max-w-3xl items-center justify-center py-8">
            <section class="w-full overflow-hidden rounded-[32px] border border-emerald-100 bg-white shadow-[0_24px_80px_-32px_rgba(5,150,105,0.28)]" role="status">
                <div class="h-2 bg-gradient-to-r from-lime-400 via-emerald-500 to-green-600"></div>
                <div class="px-6 py-10 text-center sm:px-12 sm:py-14">
                    <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-emerald-50 ring-8 ring-emerald-50/70">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M12 22s8-4 8-11V5l-8-3-8 3v6c0 7 8 11 8 11z"></path>
                            <path d="m9 12 2 2 4-4"></path>
                        </svg>
                    </div>

                    <p class="mt-8 text-xs font-extrabold uppercase tracking-[0.2em] text-emerald-700">Bukti pembayaran berhasil diterima</p>
                    <h1 class="mx-auto mt-3 max-w-xl text-3xl font-black leading-tight tracking-tight text-slate-900 sm:text-4xl">
                        Pembayaran Anda telah terkirim
                    </h1>
                    <p class="mx-auto mt-3 max-w-lg text-base leading-7 text-slate-500">
                        Silakan tunggu konfirmasi dari bank sampah. Status pesanan akan diperbarui setelah pembayaran selesai diperiksa.
                    </p>

                    <div class="mx-auto mt-8 grid max-w-md grid-cols-2 divide-x divide-slate-200 rounded-2xl border border-slate-100 bg-slate-50 px-4 py-4 text-left">
                        <div class="pr-4">
                            <p class="text-xs font-semibold text-slate-500">Nomor pesanan</p>
                            <p class="mt-1 font-extrabold text-slate-800">#{{ $order->id }}</p>
                        </div>
                        <div class="pl-4">
                            <p class="text-xs font-semibold text-slate-500">Total pembayaran</p>
                            <p class="mt-1 font-extrabold text-emerald-700">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row">
                        <a href="{{ route('marketplace.orders') }}" class="inline-flex items-center justify-center rounded-xl bg-emerald-600 px-6 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-emerald-700 focus:outline-none focus:ring-4 focus:ring-emerald-100">
                            Lihat Status Pesanan
                        </a>
                        <a href="{{ route('marketplace') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-6 py-3 text-sm font-bold text-slate-700 transition hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-100">
                            Kembali ke Marketplace
                        </a>
                    </div>
                </div>
            </section>
        </div>
    @else
        <div class="mx-auto max-w-4xl space-y-6">
            <a href="{{ route('marketplace.product', $order->product) }}" class="inline-flex items-center text-sm font-bold text-emerald-700 hover:text-emerald-900">
                ← Kembali ke detail produk
            </a>

            @if (session('success'))
                <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">{{ $errors->first() }}</div>
            @endif

            <section class="rounded-[28px] border border-slate-200 bg-white p-5 shadow-sm md:p-8">
                <p class="text-sm font-semibold uppercase tracking-wide text-emerald-600">Pesanan berhasil dibuat</p>
                <h1 class="mt-1 text-3xl font-black text-slate-900">Konfirmasi Pembayaran</h1>
                <p class="mt-2 text-sm text-slate-500">Silakan bayar sesuai total pesanan melalui QRIS milik {{ $order->product->bankSampah->name }}, lalu unggah bukti pembayarannya.</p>

                <div class="mt-6 grid gap-6 md:grid-cols-2">
                    <div class="rounded-2xl bg-slate-50 p-5">
                        <h2 class="font-black text-slate-900">Ringkasan Pesanan</h2>
                        <div class="mt-4 space-y-2 text-sm">
                            <div class="flex justify-between gap-4"><span class="text-slate-500">Produk</span><span class="text-right font-bold text-slate-800">{{ $order->product->name }}</span></div>
                            <div class="flex justify-between gap-4"><span class="text-slate-500">Jumlah</span><span class="font-bold text-slate-800">{{ $order->quantity }}</span></div>
                            <div class="flex justify-between gap-4 border-t border-slate-200 pt-3"><span class="font-bold text-slate-700">Total</span><span class="font-black text-lime-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span></div>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-lime-200 bg-lime-50 p-5 text-center">
                        <h2 class="font-black text-slate-900">QRIS Pembayaran</h2>
                        @if ($order->product->bankSampah->qris_image)
                            <img src="{{ asset('storage/' . $order->product->bankSampah->qris_image) }}" alt="QRIS {{ $order->product->bankSampah->name }}" class="mx-auto mt-4 max-h-64 rounded-xl bg-white p-2 object-contain">
                        @else
                            <div class="mt-4 rounded-xl bg-white px-4 py-12 text-sm text-slate-500">QRIS belum tersedia. Silakan hubungi bank sampah untuk metode pembayaran.</div>
                        @endif
                    </div>
                </div>

                <form method="POST" action="{{ route('marketplace.payment.upload', $order) }}" enctype="multipart/form-data" class="mt-6 rounded-2xl border border-slate-200 p-5">
                    @csrf
                    <label class="text-sm font-bold text-slate-700">Unggah bukti pembayaran</label>
                    <input name="payment_proof" type="file" required accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp" class="mt-2 w-full rounded-2xl border-slate-200 px-4 py-3 text-sm file:mr-3 file:rounded-xl file:border-0 file:bg-emerald-50 file:px-3 file:py-2 file:font-bold file:text-emerald-700">
                    <p class="mt-1 text-xs text-slate-500">JPG, PNG, atau WebP. Maksimal 5 MB.</p>
                    <button class="mt-4 rounded-2xl bg-gradient-to-r from-lime-500 to-green-600 px-5 py-3 text-sm font-bold text-white hover:shadow-lg">Kirim Bukti Pembayaran</button>
                </form>
            </section>
        </div>
    @endif
@endsection
