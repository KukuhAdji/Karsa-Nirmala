@extends('admin.layouts.app')

@section('title', 'Tambah Bank Sampah')

@section('content')

<div class="mx-auto w-full max-w-6xl space-y-6">

    {{-- =========================================================
        HEADER
    ========================================================== --}}
    <div>

        {{-- Breadcrumb --}}
        <div class="flex flex-wrap items-center gap-2 text-sm text-slate-400">

            <a
                href="{{ route('admin.dashboard') }}"
                class="transition hover:text-[#72ad28]"
            >
                Dashboard
            </a>

            <span>›</span>

            <a
                href="{{ route('admin.manage-bank-sampah.index') }}"
                class="transition hover:text-[#72ad28]"
            >
                Bank Sampah
            </a>

            <span>›</span>

            <span class="text-slate-500">
                Tambah Bank Sampah
            </span>

        </div>


        {{-- Page Title --}}
        <div class="mt-3">

            <h1 class="text-2xl font-bold tracking-tight text-slate-800">
                Tambah Bank Sampah
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Tambahkan data Bank Sampah baru ke dalam sistem.
            </p>

        </div>

    </div>


    {{-- =========================================================
        VALIDATION ERROR
    ========================================================== --}}
    @if ($errors->any())

        <div class="rounded-2xl border border-red-200 bg-red-50 px-5 py-4">

            <div class="flex items-start gap-3">

                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-red-100 text-sm font-bold text-red-600">
                    !
                </div>

                <div class="min-w-0">

                    <h3 class="text-sm font-semibold text-red-700">
                        Data belum dapat disimpan
                    </h3>

                    <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-red-600">

                        @foreach ($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            </div>

        </div>

    @endif


    {{-- =========================================================
        FORM
    ========================================================== --}}
    <form
        action="{{ route('admin.manage-bank-sampah.store') }}"
        method="POST"
        enctype="multipart/form-data"
        class="space-y-6"
    >

        @csrf


        {{-- =====================================================
            CARD 1 — INFORMASI BANK SAMPAH
        ====================================================== --}}
        <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            {{-- Card Header --}}
            <div class="border-b border-slate-200 px-6 py-5">

                <div class="flex items-start gap-3">

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

                    <div>

                        <h2 class="text-base font-semibold text-slate-800">
                            Informasi Bank Sampah
                        </h2>

                        <p class="mt-1 text-sm text-slate-500">
                            Masukkan informasi dasar Bank Sampah.
                        </p>

                    </div>

                </div>

            </div>


            {{-- Card Body --}}
            <div class="space-y-6 px-6 pb-8 pt-6">

                {{-- =================================================
                    NAMA
                ================================================== --}}
                <div>

                    <label
                        for="name"
                        class="mb-2 block text-sm font-medium text-slate-700"
                    >
                        Nama Bank Sampah
                        <span class="text-red-500">*</span>
                    </label>

                    <input
                        id="name"
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        placeholder="Contoh: Bank Sampah Induk Surabaya"
                        class="h-11 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-[#72ad28] focus:bg-white focus:ring-4 focus:ring-[#72ad28]/10"
                    >

                    @error('name')

                        <p class="mt-2 text-xs leading-5 text-red-500">
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                {{-- =================================================
                    ALAMAT
                ================================================== --}}
                <div>

                    <label
                        for="address"
                        class="mb-2 block text-sm font-medium text-slate-700"
                    >
                        Alamat Lengkap
                        <span class="text-red-500">*</span>
                    </label>

                    <textarea
                        id="address"
                        name="address"
                        rows="4"
                        required
                        placeholder="Masukkan alamat lengkap Bank Sampah..."
                        class="block w-full resize-none rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm leading-6 text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-[#72ad28] focus:bg-white focus:ring-4 focus:ring-[#72ad28]/10"
                    >{{ old('address') }}</textarea>

                    @error('address')

                        <p class="mt-2 text-xs leading-5 text-red-500">
                            {{ $message }}
                        </p>

                    @else

                        <p class="mt-2 text-xs leading-5 text-slate-400">
                            Gunakan alamat lengkap agar mudah ditemukan pada sistem.
                        </p>

                    @enderror

                </div>


                {{-- =================================================
                    WHATSAPP + JENIS SAMPAH
                ================================================== --}}
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                    {{-- WhatsApp --}}
                    <div>

                        <label
                            for="whatsapp"
                            class="mb-2 block text-sm font-medium text-slate-700"
                        >
                            WhatsApp
                        </label>

                        <input
                            id="whatsapp"
                            type="text"
                            name="whatsapp"
                            value="{{ old('whatsapp') }}"
                            placeholder="+62 812-3456-7890"
                            class="h-11 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-[#72ad28] focus:bg-white focus:ring-4 focus:ring-[#72ad28]/10"
                        >

                        @error('whatsapp')

                            <p class="mt-2 text-xs leading-5 text-red-500">
                                {{ $message }}
                            </p>

                        @else

                            <p class="mt-2 text-xs leading-5 text-slate-400">
                                Nomor kontak Bank Sampah.
                            </p>

                        @enderror

                    </div>


                    {{-- Jenis Sampah --}}
                    <div>

                        <label
                            for="waste_type"
                            class="mb-2 block text-sm font-medium text-slate-700"
                        >
                            Jenis Sampah
                        </label>

                        <input
                            id="waste_type"
                            type="text"
                            name="waste_type"
                            value="{{ old('waste_type') }}"
                            placeholder="Contoh: Plastik, Kertas, Logam"
                            class="h-11 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-[#72ad28] focus:bg-white focus:ring-4 focus:ring-[#72ad28]/10"
                        >

                        @error('waste_type')

                            <p class="mt-2 text-xs leading-5 text-red-500">
                                {{ $message }}
                            </p>

                        @else

                            <p class="mt-2 text-xs leading-5 text-slate-400">
                                Jenis sampah yang diterima.
                            </p>

                        @enderror

                    </div>

                </div>

            </div>

        </section>


        {{-- =====================================================
            CARD 2 — LOKASI
        ====================================================== --}}
        <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            {{-- Card Header --}}
            <div class="border-b border-slate-200 px-6 py-5">

                <div class="flex items-start gap-3">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">

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
                                d="M12 21s8-4.5 8-11a8 8 0 10-16 0c0 6.5 8 11 8 11z"
                            />

                            <circle
                                cx="12"
                                cy="10"
                                r="2.5"
                            />

                        </svg>

                    </div>

                    <div>

                        <h2 class="text-base font-semibold text-slate-800">
                            Lokasi Bank Sampah
                        </h2>

                        <p class="mt-1 text-sm text-slate-500">
                            Masukkan koordinat lokasi Bank Sampah.
                        </p>

                    </div>

                </div>

            </div>


            {{-- Card Body --}}
            <div class="px-6 pb-8 pt-6">

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                    {{-- Latitude --}}
                    <div>

                        <label
                            for="latitude"
                            class="mb-2 block text-sm font-medium text-slate-700"
                        >
                            Latitude
                            <span class="text-red-500">*</span>
                        </label>

                        <input
                            id="latitude"
                            type="number"
                            name="latitude"
                            value="{{ old('latitude') }}"
                            required
                            step="any"
                            min="-90"
                            max="90"
                            placeholder="-7.2782297"
                            class="h-11 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-[#72ad28] focus:bg-white focus:ring-4 focus:ring-[#72ad28]/10"
                        >

                        @error('latitude')

                            <p class="mt-2 text-xs leading-5 text-red-500">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    {{-- Longitude --}}
                    <div>

                        <label
                            for="longitude"
                            class="mb-2 block text-sm font-medium text-slate-700"
                        >
                            Longitude
                            <span class="text-red-500">*</span>
                        </label>

                        <input
                            id="longitude"
                            type="number"
                            name="longitude"
                            value="{{ old('longitude') }}"
                            required
                            step="any"
                            min="-180"
                            max="180"
                            placeholder="112.7539287"
                            class="h-11 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-[#72ad28] focus:bg-white focus:ring-4 focus:ring-[#72ad28]/10"
                        >

                        @error('longitude')

                            <p class="mt-2 text-xs leading-5 text-red-500">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>

                </div>


                {{-- Info Koordinat --}}
                <div class="mt-6 rounded-xl border border-blue-100 bg-blue-50/70 px-4 py-4">

                    <div class="flex items-start gap-3">

                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white text-blue-600 shadow-sm">

                            <svg
                                class="h-4 w-4"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <circle
                                    cx="12"
                                    cy="12"
                                    r="9"
                                />

                                <path
                                    stroke-linecap="round"
                                    d="M12 11v5"
                                />

                                <path
                                    stroke-linecap="round"
                                    d="M12 8h.01"
                                />

                            </svg>

                        </div>

                        <div>

                            <p class="text-sm font-medium text-blue-700">
                                Informasi Koordinat
                            </p>

                            <p class="mt-1.5 text-xs leading-5 text-blue-600">
                                Pastikan latitude dan longitude sesuai dengan
                                lokasi sebenarnya agar posisi Bank Sampah dapat
                                ditampilkan dengan tepat pada peta.
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </section>


        {{-- =====================================================
            CARD 3 — STATUS & QRIS
        ====================================================== --}}
        <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            {{-- Card Header --}}
            <div class="border-b border-slate-200 px-6 py-5">

                <div class="flex items-start gap-3">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-amber-50 text-amber-600">

                        <svg
                            class="h-5 w-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <circle
                                cx="12"
                                cy="12"
                                r="9"
                            />

                            <path
                                stroke-linecap="round"
                                d="M12 7v5l3 2"
                            />

                        </svg>

                    </div>

                    <div>

                        <h2 class="text-base font-semibold text-slate-800">
                            Status dan QRIS
                        </h2>

                        <p class="mt-1 text-sm text-slate-500">
                            Atur status operasional dan informasi pembayaran.
                        </p>

                    </div>

                </div>

            </div>


            {{-- Card Body --}}
            <div class="px-6 pb-8 pt-6">

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                    {{-- Status --}}
                    <div>

                        <label
                            for="status"
                            class="mb-2 block text-sm font-medium text-slate-700"
                        >
                            Status Operasional
                            <span class="text-red-500">*</span>
                        </label>

                        <select
                            id="status"
                            name="status"
                            required
                            class="h-11 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 text-sm text-slate-700 outline-none transition focus:border-[#72ad28] focus:bg-white focus:ring-4 focus:ring-[#72ad28]/10"
                        >

                            <option value="">
                                Pilih Status
                            </option>

                            <option
                                value="Buka"
                                {{ old('status') === 'Buka' ? 'selected' : '' }}
                            >
                                Buka
                            </option>

                            <option
                                value="Tutup"
                                {{ old('status') === 'Tutup' ? 'selected' : '' }}
                            >
                                Tutup
                            </option>

                        </select>

                        @error('status')

                            <p class="mt-2 text-xs leading-5 text-red-500">
                                {{ $message }}
                            </p>

                        @else

                            <p class="mt-2 text-xs leading-5 text-slate-400">
                                Tentukan apakah Bank Sampah sedang beroperasi.
                            </p>

                        @enderror

                    </div>


                    {{-- QRIS --}}
                    <div>

                        <label
                            for="qris_image"
                            class="mb-2 block text-sm font-medium text-slate-700"
                        >
                            QRIS
                        </label>

                        <label
                            for="qris_image"
                            class="flex h-11 w-full cursor-pointer items-center overflow-hidden rounded-xl border border-slate-200 bg-slate-50 transition hover:border-[#72ad28]/50 hover:bg-white"
                        >

                            <span class="flex h-full shrink-0 items-center border-r border-slate-200 bg-white px-4 text-sm font-medium text-slate-600">
                                Pilih File
                            </span>

                            <span
                                id="qrisFileName"
                                class="truncate px-4 text-sm text-slate-400"
                            >
                                Belum ada file dipilih
                            </span>

                        </label>

                        <input
                            id="qris_image"
                            type="file"
                            name="qris_image"
                            accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                            class="hidden"
                        >

                        <p class="mt-2 text-xs leading-5 text-slate-400">
                            JPG, JPEG, PNG, atau WEBP. Maksimal 2 MB.
                        </p>

                        @error('qris_image')

                            <p class="mt-2 text-xs leading-5 text-red-500">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>

                </div>

            </div>

        </section>


        {{-- =====================================================
            ACTION BUTTON
        ====================================================== --}}
        <div class="flex flex-col-reverse gap-3 border-t border-slate-200 pt-6 sm:flex-row sm:items-center sm:justify-end">

            <a
                href="{{ route('admin.manage-bank-sampah.index') }}"
                class="inline-flex h-11 items-center justify-center rounded-xl border border-slate-200 bg-white px-6 text-sm font-medium text-slate-600 shadow-sm transition hover:bg-slate-50"
            >
                Batal
            </a>


            <button
                type="submit"
                class="inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-[#72ad28] px-6 text-sm font-semibold text-white shadow-sm transition duration-200 hover:bg-[#629b20] hover:shadow-md"
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

                Simpan Bank Sampah

            </button>

        </div>

    </form>

</div>


{{-- =============================================================
    FILE INPUT SCRIPT
============================================================= --}}
@push('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {

    const qrisInput = document.getElementById('qris_image');
    const qrisFileName = document.getElementById('qrisFileName');

    if (!qrisInput || !qrisFileName) {
        return;
    }

    qrisInput.addEventListener('change', function () {

        if (this.files && this.files.length > 0) {

            qrisFileName.textContent = this.files[0].name;

            qrisFileName.classList.remove('text-slate-400');
            qrisFileName.classList.add('text-slate-700');

        } else {

            qrisFileName.textContent = 'Belum ada file dipilih';

            qrisFileName.classList.remove('text-slate-700');
            qrisFileName.classList.add('text-slate-400');

        }

    });

});
</script>

@endpush

@endsection
