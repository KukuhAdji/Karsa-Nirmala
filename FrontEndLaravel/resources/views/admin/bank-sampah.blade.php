@extends('admin.layouts.app')

@section('title', 'Bank Sampah')

@section('content')

<div class="space-y-6">

    {{-- =========================================================
        HEADER
    ========================================================== --}}
    <div>

        {{-- Breadcrumb --}}
        <div class="flex items-center gap-2 text-sm text-slate-400">

            <a
                href="{{ route('admin.dashboard') }}"
                class="transition hover:text-[#72ad28]"
            >
                Dashboard
            </a>

            <span>›</span>

            <span class="text-slate-500">
                Bank Sampah
            </span>

        </div>


        {{-- Title --}}
        <div class="mt-3">

            <h1 class="text-2xl font-bold text-slate-800">
                Bank Sampah
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Kelola seluruh data Bank Sampah yang terdaftar pada sistem.
            </p>

        </div>

    </div>


    {{-- =========================================================
        FLASH MESSAGE
    ========================================================== --}}
    @if (session('success'))

        <div class="rounded-2xl border border-green-200 bg-green-50 p-4">

            <div class="flex items-center gap-3">

                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-green-100 text-green-600">

                    <svg
                        class="h-4 w-4"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M5 13l4 4L19 7"
                        />
                    </svg>

                </div>

                <p class="text-sm font-medium text-green-700">
                    {{ session('success') }}
                </p>

            </div>

        </div>

    @endif


    @if (session('error'))

        <div class="rounded-2xl border border-red-200 bg-red-50 p-4">

            <div class="flex items-center gap-3">

                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-red-100 text-red-600">
                    !
                </div>

                <p class="text-sm font-medium text-red-700">
                    {{ session('error') }}
                </p>

            </div>

        </div>

    @endif


    {{-- =========================================================
        STATISTICS
    ========================================================== --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">

        {{-- Total --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-sm font-medium text-slate-500">
                        Total Bank Sampah
                    </p>

                    <p class="mt-2 text-3xl font-bold text-slate-800">
                        {{ $totalBankSampah }}
                    </p>

                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#72ad28]/10 text-[#72ad28]">

                    <svg
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M3 10.5L12 3l9 7.5"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M5.5 9.5V21h13V9.5"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M9 21v-6h6v6"
                        />

                    </svg>

                </div>

            </div>

        </div>


        {{-- Buka --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-sm font-medium text-slate-500">
                        Bank Sampah Buka
                    </p>

                    <p class="mt-2 text-3xl font-bold text-green-600">
                        {{ $bankSampahBuka }}
                    </p>

                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-green-50 text-green-600">

                    <svg
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M5 12h14"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 5v14"
                        />

                    </svg>

                </div>

            </div>

        </div>


        {{-- Tutup --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-sm font-medium text-slate-500">
                        Bank Sampah Tutup
                    </p>

                    <p class="mt-2 text-3xl font-bold text-red-500">
                        {{ $bankSampahTutup }}
                    </p>

                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-red-50 text-red-500">

                    <svg
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M6 6l12 12"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M18 6L6 18"
                        />

                    </svg>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
        MAIN CARD
    ========================================================== --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">


        {{-- =====================================================
            TOOLBAR
        ====================================================== --}}
        <div class="border-b border-slate-200 p-5">

            <form
                action="{{ route('admin.bank-sampah.index') }}"
                method="GET"
                class="flex flex-col gap-3 lg:flex-row lg:items-center"
            >

                {{-- Search --}}
                <div class="flex-1">

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari nama, alamat, atau WhatsApp..."
                        class="h-11 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-[#72ad28] focus:bg-white focus:ring-4 focus:ring-[#72ad28]/10"
                    >

                </div>


                {{-- Status --}}
                <div class="w-full lg:w-48">

                    <select
                        name="status"
                        class="h-11 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 text-sm text-slate-700 outline-none transition focus:border-[#72ad28] focus:bg-white focus:ring-4 focus:ring-[#72ad28]/10"
                    >

                        <option value="">
                            Semua Status
                        </option>

                        <option
                            value="Buka"
                            {{ request('status') === 'Buka' ? 'selected' : '' }}
                        >
                            Buka
                        </option>

                        <option
                            value="Tutup"
                            {{ request('status') === 'Tutup' ? 'selected' : '' }}
                        >
                            Tutup
                        </option>

                    </select>

                </div>


                {{-- Button --}}
                <button
                    type="submit"
                    class="inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-[#72ad28] px-5 text-sm font-semibold text-white shadow-sm transition duration-200 hover:bg-[#629b20] hover:shadow-md"
                    style="background-color: #72ad28; color: #ffffff;"
                >

                    <svg
                        class="h-4 w-4"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M21 21l-4.35-4.35m2.35-5.65a8 8 0 11-16 0 8 8 0 0116 0z"
                        />
                    </svg>

                    Terapkan

                </button>


                {{-- Tambah --}}
                <a
                    href="{{ route('admin.bank-sampah.create') }}"
                    class="inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-[#72ad28] px-5 text-sm font-semibold text-white shadow-sm transition duration-200 hover:bg-[#629b20] hover:shadow-md"
                    style="background-color: #72ad28; color: #ffffff;"
                >

                    <svg
                        class="h-4 w-4"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 5v14"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M5 12h14"
                        />

                    </svg>

                    Tambah Bank Sampah

                </a>

            </form>

        </div>


        {{-- =====================================================
            TABLE
        ====================================================== --}}
        <div class="overflow-x-auto">

            <table class="min-w-[1100px] w-full">

                <thead>

                    <tr class="border-b border-slate-200 bg-slate-50">

                        <th class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Bank Sampah
                        </th>

                        <th class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Alamat
                        </th>

                        <th class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Koordinat
                        </th>

                        <th class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                            WhatsApp
                        </th>

                        <th class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Status
                        </th>

                        <th class="px-5 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-slate-100">

                    @forelse ($bankSampahs as $bankSampah)

                        <tr class="transition hover:bg-slate-50/70">

                            {{-- Nama --}}
                            <td class="px-5 py-4">

                                <div class="flex items-center gap-3">

                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#72ad28]/10 text-[#72ad28]">

                                        <svg
                                            class="h-5 w-5"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M3 10.5L12 3l9 7.5"
                                            />

                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M5.5 9.5V21h13V9.5"
                                            />

                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M9 21v-6h6v6"
                                            />

                                        </svg>

                                    </div>


                                    <div class="min-w-0">

                                        <p class="truncate text-sm font-semibold text-slate-800">
                                            {{ $bankSampah->name }}
                                        </p>

                                        @if ($bankSampah->waste_type)

                                            <p class="mt-0.5 truncate text-xs text-slate-400">
                                                {{ $bankSampah->waste_type }}
                                            </p>

                                        @endif

                                    </div>

                                </div>

                            </td>


                            {{-- Alamat --}}
                            <td class="max-w-[320px] px-5 py-4">

                                <p class="line-clamp-2 text-sm text-slate-600">
                                    {{ $bankSampah->address }}
                                </p>

                            </td>


                            {{-- Koordinat --}}
                            <td class="px-5 py-4">

                                <div class="space-y-1 text-xs">

                                    <p class="text-slate-600">
                                        <span class="font-medium text-slate-400">
                                            Lat:
                                        </span>

                                        {{ $bankSampah->latitude }}
                                    </p>

                                    <p class="text-slate-600">
                                        <span class="font-medium text-slate-400">
                                            Long:
                                        </span>

                                        {{ $bankSampah->longitude }}
                                    </p>

                                </div>

                            </td>


                            {{-- WhatsApp --}}
                            <td class="px-5 py-4">

                                @if ($bankSampah->whatsapp)

                                    <span class="text-sm text-slate-600">
                                        {{ $bankSampah->whatsapp }}
                                    </span>

                                @else

                                    <span class="text-xs text-slate-400">
                                        —
                                    </span>

                                @endif

                            </td>


                            {{-- Status --}}
                            <td class="px-5 py-4">

                                @if ($bankSampah->status === 'Buka')

                                    <span class="inline-flex items-center rounded-full bg-green-50 px-3 py-1 text-xs font-semibold text-green-700">

                                        <span class="mr-1.5 h-1.5 w-1.5 rounded-full bg-green-500"></span>

                                        Buka

                                    </span>

                                @else

                                    <span class="inline-flex items-center rounded-full bg-red-50 px-3 py-1 text-xs font-semibold text-red-600">

                                        <span class="mr-1.5 h-1.5 w-1.5 rounded-full bg-red-500"></span>

                                        {{ $bankSampah->status ?? 'Tutup' }}

                                    </span>

                                @endif

                            </td>


                            {{-- Aksi --}}
                            <td class="px-5 py-4">

                                <div class="flex items-center justify-end gap-2">

                                    {{-- Edit --}}
                                    <a
                                        href="{{ route('admin.bank-sampah.edit', $bankSampah) }}"
                                        title="Edit Bank Sampah"
                                        class="flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 transition hover:border-[#72ad28]/30 hover:bg-[#72ad28]/10 hover:text-[#72ad28]"
                                    >

                                        <svg
                                            class="h-4 w-4"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M12 20h9"
                                            />

                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4L16.5 3.5z"
                                            />

                                        </svg>

                                    </a>


                                    {{-- Delete --}}
                                    <form
                                        action="{{ route('admin.bank-sampah.destroy', $bankSampah) }}"
                                        method="POST"
                                        onsubmit="return confirm('Apakah kamu yakin ingin menghapus Bank Sampah ini?');"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            title="Hapus Bank Sampah"
                                            class="flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 transition hover:border-red-200 hover:bg-red-50 hover:text-red-600"
                                        >

                                            <svg
                                                class="h-4 w-4"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                                stroke-width="1.8"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M3 6h18"
                                                />

                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M8 6V4h8v2"
                                                />

                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M19 6l-1 14H6L5 6"
                                                />

                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M10 11v5M14 11v5"
                                                />

                                            </svg>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="6"
                                class="px-5 py-14 text-center"
                            >

                                <div class="mx-auto flex max-w-sm flex-col items-center">

                                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">

                                        <svg
                                            class="h-7 w-7"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="1.5"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M3 10.5L12 3l9 7.5"
                                            />

                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M5.5 9.5V21h13V9.5"
                                            />

                                        </svg>

                                    </div>

                                    <h3 class="mt-4 text-sm font-semibold text-slate-700">
                                        Belum ada Bank Sampah
                                    </h3>

                                    <p class="mt-1 text-sm text-slate-400">
                                        Data Bank Sampah belum ditemukan.
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- =====================================================
            PAGINATION
        ====================================================== --}}
        @if ($bankSampahs->hasPages())

            <div class="border-t border-slate-200 px-5 py-4">

                {{ $bankSampahs->links() }}

            </div>

        @endif

    </div>

</div>

@endsection