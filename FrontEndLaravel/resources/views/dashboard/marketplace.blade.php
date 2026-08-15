@extends('layouts.app')

@section('content')

<div class="space-y-6">

    <!-- ===================================================== -->
    <!-- HEADER -->
    <!-- ===================================================== -->

    <div class="flex items-end justify-between">
        
        <div>
            <h1 class="text-3xl font-black text-slate-900">Marketplace</h1>
            <p class="mt-2 text-slate-500">Belanja produk ramah lingkungan hasil olahan daur ulang dari Bank Sampah</p>
        </div>

        <!-- Filter & Search -->
        <div class="flex items-center gap-3">
            <div class="relative hidden sm:block">
                <input 
                    type="text" 
                    placeholder="Cari produk..." 
                    class="w-64 px-4 py-2.5 rounded-[12px] border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-lime-400"
                >
                <svg xmlns="http://www.w3.org/2000/svg" class="absolute right-3 top-2.5 w-5 h-5 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <path d="m21 21-4.35-4.35"></path>
                </svg>
            </div>

            <select class="px-4 py-2.5 rounded-[12px] border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-lime-400 bg-white">
                <option value="">Semua Kategori</option>
                <option value="fashion">Fashion</option>
                <option value="accessories">Accessories</option>
                <option value="home">Home & Living</option>
                <option value="gardening">Gardening</option>
                <option value="stationery">Stationery</option>
                <option value="lifestyle">Lifestyle</option>
            </select>

            <select class="px-4 py-2.5 rounded-[12px] border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-lime-400 bg-white">
                <option value="">Urutkan Harga</option>
                <option value="low-high">Harga Termurah</option>
                <option value="high-low">Harga Termahal</option>
                <option value="newest">Terbaru</option>
                <option value="popular">Paling Populer</option>
            </select>
        </div>

    </div>

    <!-- ===================================================== -->
    <!-- PRODUCTS GRID -->
    <!-- ===================================================== -->

    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">

        @foreach($products as $product)
            
            <div class="group relative overflow-hidden rounded-[20px] border border-slate-200/80 bg-white/90 shadow-sm transition-all duration-300 hover:shadow-lg hover:border-lime-300/50 backdrop-blur-sm flex flex-col">
                
                <!-- ===== PRODUCT IMAGE ===== -->
                <div class="relative h-48 overflow-hidden bg-slate-100">
                    
                    <img 
                        src="{{ $product['image'] }}" 
                        alt="{{ $product['name'] }}" 
                        class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-110"
                    />

                    <!-- Stock Badge -->
                    <div class="absolute left-3 top-3">
                        <span class="inline-flex items-center rounded-full bg-white/95 backdrop-blur-sm px-3 py-1 text-xs font-bold text-slate-700 shadow-md">
                            📦 {{ $product['stock'] }} tersedia
                        </span>
                    </div>

                    <!-- Rating Badge -->
                    <div class="absolute right-3 top-3">
                        <span class="inline-flex items-center gap-1 rounded-full bg-gradient-to-r from-amber-400 to-orange-500 px-3 py-1 text-xs font-bold text-white shadow-md">
                            ★ {{ number_format($product['rating'], 1) }}
                        </span>
                    </div>

                    <!-- Category Tag -->
                    <div class="absolute bottom-3 left-3">
                        <span class="inline-flex items-center rounded-full bg-lime-100/95 backdrop-blur-sm px-2.5 py-1 text-xs font-bold text-lime-700 border border-lime-200/50">
                            {{ $product['category'] }}
                        </span>
                    </div>

                </div>

                <!-- ===== CONTENT ===== -->
                <div class="flex flex-1 flex-col space-y-3 p-4">
                    
                    <!-- Product Name -->
                    <div>
                        <h3 class="font-bold text-slate-900 line-clamp-2 text-sm">
                            {{ $product['name'] }}
                        </h3>
                    </div>

                    <!-- Bank Sampah Name -->
                    <div class="flex items-center gap-2">
                        <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-lime-100 text-xs font-bold text-lime-700">
                            🏪
                        </span>
                        <span class="text-xs text-slate-600 font-medium line-clamp-1">
                            {{ $product['bank_sampah'] }}
                        </span>
                    </div>

                    <!-- Description -->
                    <p class="text-xs text-slate-600 leading-5 line-clamp-2">
                        {{ $product['description'] }}
                    </p>

                    <!-- Rating & Reviews -->
                    <div class="flex items-center gap-2 text-xs text-slate-500">
                        <span>⭐ {{ $product['reviews'] }} ulasan</span>
                    </div>

                    <!-- Price Section -->
                    <div class="flex items-baseline gap-2">
                        <span class="text-lg font-black text-lime-600">
                            Rp {{ number_format($product['price'], 0, ',', '.') }}
                        </span>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-auto flex gap-2 pt-2">
                        <button 
                            type="button"
                            class="flex-1 rounded-[12px] bg-lime-50 py-2.5 text-xs font-bold text-lime-700 transition hover:bg-lime-100 border border-lime-200/50 flex items-center justify-center gap-2"
                        >
                            👁️ Lihat Detail
                        </button>
                        <button 
                            type="button"
                            class="flex-1 rounded-[12px] bg-gradient-to-r from-lime-500 to-green-600 py-2.5 text-xs font-bold text-white transition hover:shadow-lg flex items-center justify-center gap-2"
                        >
                            🛒 Beli
                        </button>
                    </div>

                </div>

            </div>

        @endforeach

    </div>

</div>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>

@endsection
