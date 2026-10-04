@extends('admin.layouts.app')
@section('title', 'Dashboard Super Admin')

@section('page-title', 'Dashboard Super Admin')

@section('content')

<div class="max-w-7xl mx-auto px-4 py-8">

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">
            Super Admin Dashboard
        </h1>

        <p class="mt-2 text-gray-500">
            Selamat datang, {{ auth()->user()->name }}.
        </p>
    </div>


    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-4">

        {{-- Total User --}}
        <div class="rounded-2xl bg-white p-6 shadow">
            <p class="text-sm text-gray-500">
                Total User
            </p>

            <p class="mt-2 text-3xl font-bold text-gray-800">
                {{ number_format($totalUsers) }}
            </p>
        </div>


        {{-- Total Bank Sampah --}}
        <div class="rounded-2xl bg-white p-6 shadow">
            <p class="text-sm text-gray-500">
                Total Bank Sampah
            </p>

            <p class="mt-2 text-3xl font-bold text-gray-800">
                {{ number_format($totalBankSampah) }}
            </p>
        </div>


        {{-- Total Produk --}}
        <div class="rounded-2xl bg-white p-6 shadow">
            <p class="text-sm text-gray-500">
                Total Produk
            </p>

            <p class="mt-2 text-3xl font-bold text-gray-800">
                {{ number_format($totalProducts) }}
            </p>
        </div>


        {{-- Total Pesanan --}}
        <div class="rounded-2xl bg-white p-6 shadow">
            <p class="text-sm text-gray-500">
                Total Pesanan
            </p>

            <p class="mt-2 text-3xl font-bold text-gray-800">
                {{ number_format($totalOrders) }}
            </p>
        </div>

    </div>

</div>

@endsection