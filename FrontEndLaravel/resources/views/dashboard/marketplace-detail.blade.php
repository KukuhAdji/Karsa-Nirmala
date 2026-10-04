@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-5xl space-y-6">
        <a href="{{ route('marketplace') }}" class="inline-flex items-center text-sm font-bold text-emerald-700 hover:text-emerald-900">
            ← Kembali ke Marketplace
        </a>

        @if (session('success'))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700">{{ session('success') }}</div>
        @endif

        <div class="grid gap-8 rounded-[28px] border border-slate-200 bg-white p-5 shadow-sm md:grid-cols-2 md:p-8">
            <div class="overflow-hidden rounded-2xl bg-slate-100">
                <img src="{{ $product->image ? (preg_match('/^https?:\/\//i', $product->image) ? $product->image : asset('storage/' . $product->image)) : asset('images/karsa-nirmala-logo.png') }}"
                    alt="{{ $product->name }}" class="h-full min-h-80 w-full object-cover">
            </div>
            <div>
                <span class="rounded-full bg-lime-100 px-3 py-1 text-xs font-bold text-lime-700">{{ $product->category ?: 'Produk daur ulang' }}</span>
                <h1 class="mt-4 text-3xl font-black text-slate-900">{{ $product->name }}</h1>
                <p class="mt-2 text-sm text-slate-500">{{ $product->bankSampah->name }}</p>
                <p class="mt-6 text-2xl font-black text-lime-600">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                <p class="mt-4 leading-7 text-slate-600">{{ $product->description ?: 'Tidak ada deskripsi produk.' }}</p>
                <p class="mt-4 text-sm font-bold {{ $product->stock > 0 ? 'text-emerald-600' : 'text-red-600' }}">
                    {{ $product->stock > 0 ? $product->stock . ' tersedia' : 'Stok habis' }}
                </p>
            </div>
        </div>

        @if ($product->stock > 0)
            <section id="buy" class="rounded-[28px] border border-slate-200 bg-white p-5 shadow-sm md:p-8">
                <h2 class="text-xl font-black text-slate-900">Beli Produk</h2>
                <p class="mt-1 text-sm text-slate-500">Transfer melalui QRIS, isi data penerima, lalu unggah bukti pembayaran untuk mengirim pesanan.</p>
                <form method="POST" action="{{ route('marketplace.product.buy', $product) }}" enctype="multipart/form-data" class="mt-5 grid gap-4 md:grid-cols-2">
                    @csrf
                    <div class="rounded-2xl border border-lime-200 bg-lime-50 p-5 text-center md:col-span-2">
                        <h3 class="font-black text-slate-900">QRIS {{ $product->bankSampah->name }}</h3>
                        @if ($product->bankSampah->qris_image)
                            <img src="{{ asset('storage/' . $product->bankSampah->qris_image) }}" alt="QRIS {{ $product->bankSampah->name }}" class="mx-auto mt-4 max-h-72 rounded-xl bg-white p-2 object-contain">
                        @else
                            <p class="mt-3 rounded-xl bg-white px-4 py-6 text-sm text-slate-600">QRIS belum tersedia. Silakan hubungi bank sampah sebelum melanjutkan pembelian.</p>
                        @endif
                    </div>
                    <div>
                        <label class="text-sm font-bold text-slate-700">Nama penerima</label>
                        <input name="customer_name" required value="{{ old('customer_name', auth()->user()->name) }}" class="mt-2 w-full rounded-2xl border-slate-200 px-4 py-3 text-sm">
                    </div>
                    <div>
                        <label class="text-sm font-bold text-slate-700">Nomor telepon</label>
                        <input name="customer_phone" required value="{{ old('customer_phone') }}" class="mt-2 w-full rounded-2xl border-slate-200 px-4 py-3 text-sm">
                    </div>
                    <div>
                        <label class="text-sm font-bold text-slate-700">Jumlah</label>
                        <input name="quantity" type="number" min="1" max="{{ $product->stock }}" required value="{{ old('quantity', 1) }}" class="mt-2 w-full rounded-2xl border-slate-200 px-4 py-3 text-sm">
                    </div>
                    <div class="md:col-span-2">
                        <label class="text-sm font-bold text-slate-700">Alamat pengiriman</label>
                        <textarea name="shipping_address" rows="3" required class="mt-2 w-full rounded-2xl border-slate-200 px-4 py-3 text-sm">{{ old('shipping_address') }}</textarea>
                    </div>
                    <div class="md:col-span-2">
                        <label for="payment_proof" class="text-sm font-bold text-slate-700">Bukti pembayaran <span class="text-red-600">*</span></label>
                        <input id="payment_proof" name="payment_proof" type="file" required accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp" class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm file:mr-3 file:rounded-xl file:border-0 file:bg-emerald-50 file:px-3 file:py-2 file:font-bold file:text-emerald-700">
                        <p class="mt-1 text-xs text-slate-500">Wajib diunggah sebelum pesanan dapat dikirim. JPG, PNG, atau WebP, maksimal 5 MB.</p>
                    </div>
                    @if ($errors->any())
                        <div class="md:col-span-2 rounded-2xl bg-red-50 px-4 py-3 text-sm text-red-700">{{ $errors->first() }}</div>
                    @endif
                    <button class="md:col-span-2 rounded-2xl bg-gradient-to-r from-lime-500 to-green-600 px-5 py-3 text-sm font-bold text-white hover:shadow-lg">Kirim Pesanan &amp; Bukti Pembayaran</button>
                </form>
            </section>
        @endif
    </div>
@endsection
