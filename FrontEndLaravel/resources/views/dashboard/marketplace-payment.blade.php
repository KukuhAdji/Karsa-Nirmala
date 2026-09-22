@extends('layouts.app')

@section('content')
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
                @if ($order->payment_proof)
                    <p class="mt-3 text-sm font-semibold text-emerald-700">Bukti pembayaran sudah dikirim. Anda dapat mengunggah ulang jika diperlukan.</p>
                @endif
                <button class="mt-4 rounded-2xl bg-gradient-to-r from-lime-500 to-green-600 px-5 py-3 text-sm font-bold text-white hover:shadow-lg">Kirim Bukti Pembayaran</button>
            </form>
        </section>
    </div>
@endsection
