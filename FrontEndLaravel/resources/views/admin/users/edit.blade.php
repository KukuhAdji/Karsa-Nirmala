@extends('admin.layouts.app')

@section('title', 'Edit Akun')

@section('content')

<div class="space-y-6">

    {{-- =========================================================
        BREADCRUMB
    ========================================================== --}}
    <div>
        <div class="flex items-center gap-2 text-sm text-slate-400">

            <a
                href="{{ route('admin.dashboard') }}"
                class="transition hover:text-[#72ad28]"
            >
                Dashboard
            </a>

            <span>›</span>

            <a
                href="{{ route('admin.users.index') }}"
                class="transition hover:text-[#72ad28]"
            >
                Manajemen Akun
            </a>

            <span>›</span>

            <span class="text-slate-500">
                Edit Akun
            </span>

        </div>

        <div class="mt-3">
            <h1 class="text-2xl font-bold text-slate-800">
                Edit Akun
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Perbarui informasi akun dan hak akses pengguna.
            </p>
        </div>
    </div>


    {{-- =========================================================
        ERROR VALIDATION
    ========================================================== --}}
    @if ($errors->any())
        <div class="rounded-2xl border border-red-200 bg-red-50 p-4">

            <div class="flex items-start gap-3">

                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-red-100 text-red-600">
                    !
                </div>

                <div>
                    <h3 class="text-sm font-semibold text-red-700">
                        Terdapat kesalahan
                    </h3>

                    <ul class="mt-1 list-disc space-y-1 pl-5 text-sm text-red-600">

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
        action="{{ route('admin.users.update', $user) }}"
        method="POST"
        class="space-y-6"
    >

        @csrf
        @method('PUT')


        {{-- =====================================================
            INFORMASI AKUN
        ====================================================== --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            {{-- Header --}}
            <div class="border-b border-slate-200 px-6 py-5">

                <h2 class="text-base font-semibold text-slate-800">
                    Informasi Akun
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Perbarui informasi dasar akun pengguna.
                </p>

            </div>


            {{-- Content --}}
            <div class="grid grid-cols-1 gap-5 px-6 py-6 lg:grid-cols-2">

                {{-- Nama --}}
                <div>

                    <label
                        for="name"
                        class="mb-2 block text-sm font-medium text-slate-700"
                    >
                        Nama Lengkap
                        <span class="text-red-500">*</span>
                    </label>

                    <input
                        id="name"
                        type="text"
                        name="name"
                        value="{{ old('name', $user->name) }}"
                        required
                        class="h-11 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-[#72ad28] focus:bg-white focus:ring-4 focus:ring-[#72ad28]/10"
                    >

                    @error('name')
                        <p class="mt-1 text-xs text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Email --}}
                <div>

                    <label
                        for="email"
                        class="mb-2 block text-sm font-medium text-slate-700"
                    >
                        Email
                        <span class="text-red-500">*</span>
                    </label>

                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email', $user->email) }}"
                        required
                        class="h-11 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-[#72ad28] focus:bg-white focus:ring-4 focus:ring-[#72ad28]/10"
                    >

                    @error('email')
                        <p class="mt-1 text-xs text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Password Baru --}}
                <div>

                    <label
                        for="password"
                        class="mb-2 block text-sm font-medium text-slate-700"
                    >
                        Password Baru
                    </label>

                    <input
                        id="password"
                        type="password"
                        name="password"
                        placeholder="Kosongkan jika tidak ingin mengubah"
                        autocomplete="new-password"
                        class="h-11 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-[#72ad28] focus:bg-white focus:ring-4 focus:ring-[#72ad28]/10"
                    >

                    <p class="mt-1 text-xs text-slate-400">
                        Kosongkan jika password tidak ingin diubah.
                    </p>

                    @error('password')
                        <p class="mt-1 text-xs text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Konfirmasi Password --}}
                <div>

                    <label
                        for="password_confirmation"
                        class="mb-2 block text-sm font-medium text-slate-700"
                    >
                        Konfirmasi Password Baru
                    </label>

                    <input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        placeholder="Ulangi password baru"
                        autocomplete="new-password"
                        class="h-11 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-[#72ad28] focus:bg-white focus:ring-4 focus:ring-[#72ad28]/10"
                    >

                    <p class="mt-1 text-xs text-slate-400">
                        Isi hanya jika password baru diubah.
                    </p>

                </div>

            </div>

        </div>


        {{-- =====================================================
            HAK AKSES
        ====================================================== --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            {{-- Header --}}
            <div class="border-b border-slate-200 px-6 py-5">

                <h2 class="text-base font-semibold text-slate-800">
                    Hak Akses
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Perbarui role dan keterhubungan akun dengan Bank Sampah.
                </p>

            </div>


            {{-- Content --}}
            <div class="space-y-5 px-6 py-6">

                @php
                    $isCurrentSuperAdmin =
                        auth()->id() === $user->id
                        && $user->role === 'super_admin';

                    $selectedRole = $isCurrentSuperAdmin
                        ? 'super_admin'
                        : old('role', $user->role);
                @endphp


                {{-- Role --}}
                <div>

                    <label
                        for="role"
                        class="mb-2 block text-sm font-medium text-slate-700"
                    >
                        Role
                        <span class="text-red-500">*</span>
                    </label>


                    @if ($isCurrentSuperAdmin)

                        {{-- 
                            Hidden input tetap mengirim role ke server
                            karena select disabled tidak dikirim oleh browser.
                        --}}
                        <input
                            type="hidden"
                            name="role"
                            value="super_admin"
                        >


                        <select
                            id="role"
                            disabled
                            class="h-11 w-full cursor-not-allowed appearance-none rounded-xl border border-slate-200 bg-slate-100 px-4 text-sm font-medium text-slate-500 outline-none"
                        >

                            <option value="super_admin" selected>
                                Super Admin
                            </option>

                        </select>


                        <div class="mt-2 flex items-start gap-2">

                            <div class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-blue-50 text-xs font-bold text-blue-600">
                                i
                            </div>

                            <p class="text-xs leading-5 text-slate-500">
                                Role Super Admin pada akun yang sedang digunakan
                                tidak dapat diubah demi menjaga akses administrator.
                            </p>

                        </div>

                    @else

                        <select
                            id="role"
                            name="role"
                            required
                            class="h-11 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 text-sm text-slate-700 outline-none transition focus:border-[#72ad28] focus:bg-white focus:ring-4 focus:ring-[#72ad28]/10"
                        >

                            <option
                                value="user"
                                {{ $selectedRole === 'user' ? 'selected' : '' }}
                            >
                                User
                            </option>

                            <option
                                value="admin_bank_sampah"
                                {{ $selectedRole === 'admin_bank_sampah' ? 'selected' : '' }}
                            >
                                Admin Bank Sampah
                            </option>

                            <option
                                value="super_admin"
                                {{ $selectedRole === 'super_admin' ? 'selected' : '' }}
                            >
                                Super Admin
                            </option>

                        </select>

                    @endif


                    @error('role')
                        <p class="mt-1 text-xs text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- =================================================
                    BANK SAMPAH
                ================================================== --}}
                <div
                    id="bankSampahWrapper"
                    class="{{ $selectedRole === 'admin_bank_sampah' ? '' : 'hidden' }}"
                >

                    <label
                        for="bank_sampah_id"
                        class="mb-2 block text-sm font-medium text-slate-700"
                    >
                        Bank Sampah
                        <span class="text-red-500">*</span>
                    </label>

                    <select
                        id="bank_sampah_id"
                        name="bank_sampah_id"
                        class="h-11 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 text-sm text-slate-700 outline-none transition focus:border-[#72ad28] focus:bg-white focus:ring-4 focus:ring-[#72ad28]/10"
                    >

                        <option value="">
                            Pilih Bank Sampah
                        </option>

                        @foreach ($bankSampahs as $bankSampah)

                            <option
                                value="{{ $bankSampah->id }}"
                                {{ (string) old('bank_sampah_id', $user->bank_sampah_id) === (string) $bankSampah->id ? 'selected' : '' }}
                            >
                                {{ $bankSampah->name }}
                            </option>

                        @endforeach

                    </select>

                    @error('bank_sampah_id')
                        <p class="mt-1 text-xs text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- =================================================
                    INFORMASI HAK AKSES
                ================================================== --}}
                <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">

                    <div class="flex items-start gap-3">

                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white text-slate-500 shadow-sm">
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
                                    d="M12 17v.01M12 10a2 2 0 100 4m0-4V7a2 2 0 012-2h1a2 2 0 012 2v3"
                                />
                            </svg>
                        </div>

                        <div>

                            <h3 class="text-sm font-medium text-slate-700">
                                Informasi Hak Akses
                            </h3>

                            <p class="mt-1 text-xs leading-5 text-slate-500">
                                User dapat menggunakan fitur aplikasi.
                                Admin Bank Sampah mengelola Bank Sampah yang ditugaskan.
                                Super Admin memiliki akses penuh terhadap sistem.
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- =====================================================
            ACTION BUTTON
        ====================================================== --}}
        <div class="flex items-center gap-3">

            <a
                href="{{ route('admin.users.index') }}"
                class="inline-flex h-11 items-center justify-center rounded-xl border border-slate-200 bg-white px-5 text-sm font-medium text-slate-600 shadow-sm transition hover:bg-slate-50"
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
                        d="M5 12h14M13 6l6 6-6 6"
                    />
                </svg>

                Simpan Perubahan

            </button>

        </div>

    </form>

</div>


{{-- =============================================================
    JAVASCRIPT
============================================================= --}}
@push('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {

    const roleSelect = document.getElementById('role');
    const bankSampahWrapper = document.getElementById('bankSampahWrapper');

    if (!roleSelect || !bankSampahWrapper) {
        return;
    }

    function toggleBankSampah() {

        if (roleSelect.value === 'admin_bank_sampah') {

            bankSampahWrapper.classList.remove('hidden');

        } else {

            bankSampahWrapper.classList.add('hidden');

        }
    }

    roleSelect.addEventListener('change', toggleBankSampah);

    toggleBankSampah();

});
</script>

@endpush

@endsection