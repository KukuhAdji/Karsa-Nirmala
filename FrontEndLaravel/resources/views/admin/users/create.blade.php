@extends('admin.layouts.app')

@section('title', 'Tambah Akun')

@section('content')

    <div class="space-y-6">

        {{-- ============================================================
        HEADER
        ============================================================= --}}
        <div>

            {{-- Breadcrumb --}}
            <div class="mb-2 flex items-center gap-2 text-sm text-slate-500">

                <a href="{{ route('admin.dashboard') }}" class="transition hover:text-[#6ba522]">
                    Dashboard
                </a>

                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m9 5 7 7-7 7" />
                </svg>

                <a href="{{ route('admin.users.index') }}" class="transition hover:text-[#6ba522]">
                    Manajemen Akun
                </a>

                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m9 5 7 7-7 7" />
                </svg>

                <span class="text-slate-700">
                    Tambah Akun
                </span>

            </div>


            <h1 class="text-2xl font-bold tracking-tight text-slate-800 sm:text-3xl">
                Tambah Akun
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Tambahkan akun baru dan tentukan hak akses pengguna.
            </p>

        </div>


        {{-- ============================================================
        FORM
        ============================================================= --}}
        <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">

            @csrf


            {{-- ========================================================
            ACCOUNT INFORMATION
            ========================================================= --}}
            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">

                <div class="border-b border-slate-100 px-6 py-5">

                    <h2 class="text-base font-semibold text-slate-800">
                        Informasi Akun
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Masukkan informasi dasar akun pengguna.
                    </p>

                </div>


                <div class="grid grid-cols-1 gap-5 p-6 md:grid-cols-2">

                    {{-- Nama --}}
                    <div>

                        <label for="name" class="mb-2 block text-sm font-medium text-slate-700">
                            Nama Lengkap
                            <span class="text-red-500">*</span>
                        </label>

                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                            placeholder="Masukkan nama lengkap" autocomplete="name"
                            class="h-11 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-[#72ad28] focus:bg-white focus:ring-4 focus:ring-[#72ad28]/10 @error('name') border-red-300 @enderror">

                        @error('name')
                            <p class="mt-1.5 text-xs text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- Email --}}
                    <div>

                        <label for="email" class="mb-2 block text-sm font-medium text-slate-700">
                            Email
                            <span class="text-red-500">*</span>
                        </label>

                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                            placeholder="contoh@email.com" autocomplete="email"
                            class="h-11 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-[#72ad28] focus:bg-white focus:ring-4 focus:ring-[#72ad28]/10 @error('email') border-red-300 @enderror">

                        @error('email')
                            <p class="mt-1.5 text-xs text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- Password --}}
                    <div>

                        <label for="password" class="mb-2 block text-sm font-medium text-slate-700">
                            Password
                            <span class="text-red-500">*</span>
                        </label>

                        <input type="password" id="password" name="password" placeholder="Minimal 8 karakter"
                            autocomplete="new-password"
                            class="h-11 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-[#72ad28] focus:bg-white focus:ring-4 focus:ring-[#72ad28]/10 @error('password') border-red-300 @enderror">

                        <p class="mt-1.5 text-xs text-slate-400">
                            Password minimal 8 karakter.
                        </p>

                        @error('password')
                            <p class="mt-1.5 text-xs text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- Confirm Password --}}
                    <div>

                        <label for="password_confirmation" class="mb-2 block text-sm font-medium text-slate-700">
                            Konfirmasi Password
                            <span class="text-red-500">*</span>
                        </label>

                        <input type="password" id="password_confirmation" name="password_confirmation"
                            placeholder="Ulangi password" autocomplete="new-password"
                            class="h-11 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-[#72ad28] focus:bg-white focus:ring-4 focus:ring-[#72ad28]/10">

                    </div>

                </div>

            </div>


            {{-- ========================================================
            ACCESS & ROLE
            ========================================================= --}}
            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">

                <div class="border-b border-slate-100 px-6 py-5">

                    <h2 class="text-base font-semibold text-slate-800">
                        Hak Akses
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Tentukan peran akun dan akses terhadap Bank Sampah.
                    </p>

                </div>


                <div class="space-y-5 p-6">

                    {{-- Role --}}
                    <div>

                        <label for="role" class="mb-2 block text-sm font-medium text-slate-700">
                            Role
                            <span class="text-red-500">*</span>
                        </label>

                        <select id="role" name="role"
                            class="h-11 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 text-sm text-slate-700 outline-none transition focus:border-[#72ad28] focus:bg-white focus:ring-4 focus:ring-[#72ad28]/10 @error('role') border-red-300 @enderror">

                            <option value="">
                                Pilih Role
                            </option>

                            <option value="user" @selected(old('role') === 'user')>
                                User
                            </option>

                            <option value="admin_bank_sampah" @selected(old('role') === 'admin_bank_sampah')>
                                Admin Bank Sampah
                            </option>

                            <option value="super_admin" @selected(old('role') === 'super_admin')>
                                Super Admin
                            </option>

                        </select>

                        @error('role')
                            <p class="mt-1.5 text-xs text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- Bank Sampah --}}
                    <div id="bank-sampah-wrapper" class="{{ old('role') === 'admin_bank_sampah' ? '' : 'hidden' }}">

                        <label for="bank_sampah_id" class="mb-2 block text-sm font-medium text-slate-700">
                            Bank Sampah
                            <span class="text-red-500">*</span>
                        </label>

                        <select id="bank_sampah_id" name="bank_sampah_id"
                            class="h-11 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 text-sm text-slate-700 outline-none transition focus:border-[#72ad28] focus:bg-white focus:ring-4 focus:ring-[#72ad28]/10 @error('bank_sampah_id') border-red-300 @enderror">

                            <option value="">
                                Pilih Bank Sampah
                            </option>

                            @foreach($bankSampahs as $bankSampah)

                                <option value="{{ $bankSampah->id }}" @selected(
                                    old('bank_sampah_id') == $bankSampah->id
                                )>
                                    {{ $bankSampah->name }}
                                </option>

                            @endforeach

                        </select>

                        <p class="mt-1.5 text-xs text-slate-400">
                            Wajib dipilih jika role adalah Admin Bank Sampah.
                        </p>

                        @error('bank_sampah_id')
                            <p class="mt-1.5 text-xs text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- Role Information --}}
                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">

                        <div class="flex gap-3">

                            <div
                                class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-white text-slate-500">

                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 16.5v-4m0-4h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>

                            </div>

                            <div>

                                <p class="text-sm font-medium text-slate-700">
                                    Informasi Hak Akses
                                </p>

                                <p class="mt-1 text-xs leading-5 text-slate-500">
                                    User dapat menggunakan fitur aplikasi.
                                    Admin Bank Sampah mengelola Bank Sampah yang
                                    ditugaskan. Super Admin memiliki akses penuh
                                    terhadap sistem.
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ========================================================
            ACTION BUTTONS
            ========================================================= --}}
            <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

                <a href="{{ route('admin.users.index') }}"
                    class="inline-flex h-11 items-center justify-center rounded-xl border border-slate-200 bg-white px-6 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                    Batal
                </a>

                <button type="submit"
                    class="inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-[#72ad28] px-6 text-sm font-semibold text-white shadow-sm transition duration-200 hover:bg-[#629b20] hover:shadow-md"
                    style="background-color: #72ad28; color: #ffffff;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-7-7 7 7-7 7" />
                    </svg>

                    Simpan Akun
                </button>

            </div>

        </form>

    </div>


    {{-- ================================================================
    ROLE → BANK SAMPAH INTERACTION
    ================================================================ --}}
    @push('scripts')

        <script>
            document.addEventListener('DOMContentLoaded', function () {

                const roleSelect = document.getElementById('role');
                const bankSampahWrapper = document.getElementById('bank-sampah-wrapper');
                const bankSampahSelect = document.getElementById('bank_sampah_id');

                function updateBankSampahVisibility() {

                    if (roleSelect.value === 'admin_bank_sampah') {

                        bankSampahWrapper.classList.remove('hidden');

                        bankSampahSelect.setAttribute('required', 'required');

                    } else {

                        bankSampahWrapper.classList.add('hidden');

                        bankSampahSelect.removeAttribute('required');

                        bankSampahSelect.value = '';

                    }

                }


                roleSelect.addEventListener(
                    'change',
                    updateBankSampahVisibility
                );


                updateBankSampahVisibility();

            });
        </script>

    @endpush

@endsection