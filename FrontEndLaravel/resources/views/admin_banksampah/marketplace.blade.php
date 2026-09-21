@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-6xl space-y-6">
        <div>
            <p class="text-sm font-semibold uppercase tracking-wide text-emerald-600">Admin Bank Sampah</p>
            <h1 class="mt-1 text-3xl font-black text-slate-900">Kelola Katalog Marketplace</h1>
            <p class="mt-2 text-sm text-slate-500">
                Kelola produk yang ditampilkan atas nama {{ $bankSampah->name }}. Data ini hanya dapat diakses oleh bank sampah Anda.
            </p>
        </div>

        @if (session('success'))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                <p class="font-bold">Periksa kembali data produk:</p>
                <ul class="mt-2 list-inside list-disc">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif

        <section class="rounded-[28px] border border-slate-200 bg-white p-5 shadow-sm sm:p-7">
            <h2 class="text-xl font-black text-slate-900">Tambah Produk</h2>
            <form method="POST" action="{{ route('admin.bank-sampah.catalog.store') }}" enctype="multipart/form-data" class="mt-5 grid gap-4 md:grid-cols-2">
                @csrf
                @include('admin_banksampah.partials.product-fields', ['product' => null, 'prefix' => ''])
                <div class="md:col-span-2">
                    <button class="rounded-2xl bg-emerald-600 px-5 py-3 text-sm font-bold text-white hover:bg-emerald-700">Tambah ke Katalog</button>
                </div>
            </form>
        </section>

        <section class="space-y-4">
            <h2 class="text-xl font-black text-slate-900">Produk Saya ({{ $products->count() }})</h2>
            @forelse ($products as $product)
                <div class="rounded-[28px] border border-slate-200 bg-white p-5 shadow-sm sm:p-7">
                    <form method="POST" action="{{ route('admin.bank-sampah.catalog.update', $product) }}" enctype="multipart/form-data" class="grid gap-4 md:grid-cols-2">
                        @csrf
                        @method('PUT')
                        @include('admin_banksampah.partials.product-fields', ['product' => $product, 'prefix' => ''])
                        <div class="flex flex-wrap gap-2 md:col-span-2">
                            <button class="rounded-2xl bg-emerald-600 px-5 py-3 text-sm font-bold text-white hover:bg-emerald-700">Simpan Perubahan</button>
                        </div>
                    </form>
                    <form method="POST" action="{{ route('admin.bank-sampah.catalog.destroy', $product) }}" class="mt-2" onsubmit="return confirm('Hapus produk ini dari katalog?')">
                        @csrf
                        @method('DELETE')
                        <button class="rounded-2xl border border-red-200 px-5 py-3 text-sm font-bold text-red-600 hover:bg-red-50">Hapus</button>
                    </form>
                </div>
            @empty
                <div class="rounded-[28px] border border-dashed border-slate-300 bg-white p-8 text-center text-sm text-slate-500">Belum ada produk di katalog bank sampah Anda.</div>
            @endforelse
        </section>
    </div>
@endsection
