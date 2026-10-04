@extends('admin.layouts.app')

@section('title', 'Manajemen Akun')

@section('content')
<div class="space-y-6">

    {{-- ============================================================
        PAGE HEADER
    ============================================================= --}}
    <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">

        <div>
            {{-- Breadcrumb --}}
            <div class="mb-2 flex items-center gap-2 text-sm text-slate-500">

                <a
                    href="{{ route('admin.dashboard') }}"
                    class="transition hover:text-[#6ba522]"
                >
                    Dashboard
                </a>

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="m9 5 7 7-7 7"
                    />
                </svg>

                <span class="text-slate-700">
                    Manajemen Akun
                </span>

            </div>

            {{-- Title --}}
            <h1 class="text-2xl font-bold tracking-tight text-slate-800 sm:text-3xl">
                Manajemen Akun
            </h1>

            <p class="mt-1 max-w-2xl text-sm text-slate-500">
                Kelola akun pengguna, administrator Bank Sampah, dan Super Admin
                dalam satu halaman.
            </p>
        </div>


        {{-- Add Account --}}
        <a
            href="{{ route('admin.users.create') }}"
            class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-[#72ad28] px-5 py-3 text-sm font-semibold text-white shadow-sm transition duration-200 hover:bg-[#629b20] hover:shadow-md sm:w-auto"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M12 5v14m7-7H5"
                />
            </svg>

            Tambah Akun
        </a>

    </div>


    {{-- ============================================================
        STATISTIC CARDS
    ============================================================= --}}
    @php
        $totalAkun = $users->total();

        $totalSuperAdmin = \App\Models\User::where(
            'role',
            'super_admin'
        )->count();

        $totalAdminBank = \App\Models\User::where(
            'role',
            'admin_bank_sampah'
        )->count();

        $totalUser = \App\Models\User::where(
            'role',
            'user'
        )->count();
    @endphp


    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

        {{-- Total Akun --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

            <div class="flex items-start justify-between">

                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Total Akun
                    </p>

                    <p class="mt-2 text-3xl font-bold tracking-tight text-slate-800">
                        {{ $totalAkun }}
                    </p>

                    <p class="mt-1 text-xs text-slate-400">
                        Seluruh akun terdaftar
                    </p>
                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-slate-100 text-slate-600">

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M15 19a3 3 0 1 0-6 0m9-8a6 6 0 1 1-12 0 6 6 0 0 1 12 0Z"
                        />
                    </svg>

                </div>

            </div>

        </div>


        {{-- User --}}
        <div class="rounded-2xl border border-emerald-100 bg-white p-5 shadow-sm">

            <div class="flex items-start justify-between">

                <div>
                    <p class="text-sm font-medium text-slate-500">
                        User
                    </p>

                    <p class="mt-2 text-3xl font-bold tracking-tight text-slate-800">
                        {{ $totalUser }}
                    </p>

                    <p class="mt-1 text-xs text-slate-400">
                        Pengguna aplikasi
                    </p>
                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M15.75 6.75a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 19.125a6.75 6.75 0 0 1 15 0"
                        />
                    </svg>

                </div>

            </div>

        </div>


        {{-- Admin Bank Sampah --}}
        <div class="rounded-2xl border border-blue-100 bg-white p-5 shadow-sm">

            <div class="flex items-start justify-between">

                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Admin Bank Sampah
                    </p>

                    <p class="mt-2 text-3xl font-bold tracking-tight text-slate-800">
                        {{ $totalAdminBank }}
                    </p>

                    <p class="mt-1 text-xs text-slate-400">
                        Pengelola Bank Sampah
                    </p>
                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-600">

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M3 21h18M5 21V9l7-5 7 5v12M9 21v-6h6v6M8 10h.01M12 10h.01M16 10h.01"
                        />
                    </svg>

                </div>

            </div>

        </div>


        {{-- Super Admin --}}
        <div class="rounded-2xl border border-violet-100 bg-white p-5 shadow-sm">

            <div class="flex items-start justify-between">

                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Super Admin
                    </p>

                    <p class="mt-2 text-3xl font-bold tracking-tight text-slate-800">
                        {{ $totalSuperAdmin }}
                    </p>

                    <p class="mt-1 text-xs text-slate-400">
                        Administrator sistem
                    </p>
                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-violet-50 text-violet-600">

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 3 4.5 6v5.25c0 4.67 3.18 8.78 7.5 9.75 4.32-.97 7.5-5.08 7.5-9.75V6L12 3Z"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m9.5 12 1.5 1.5 3.5-3.5"
                        />
                    </svg>

                </div>

            </div>

        </div>

    </div>


    {{-- ============================================================
        SEARCH & FILTER
    ============================================================= --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

        <div class="mb-4">

            <h2 class="text-base font-semibold text-slate-800">
                Daftar Akun
            </h2>

            <p class="mt-1 text-xs text-slate-500">
                Gunakan pencarian atau filter untuk menemukan akun.
            </p>

        </div>


        <form
            method="GET"
            action="{{ route('admin.users.index') }}"
            class="grid grid-cols-1 gap-3 lg:grid-cols-[minmax(0,1fr)_230px_auto]"
        >

            {{-- Search --}}
            <div>

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari berdasarkan nama atau email..."
                    class="h-11 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-[#72ad28] focus:bg-white focus:ring-4 focus:ring-[#72ad28]/10"
                >

            </div>


            {{-- Role Filter --}}
            <select
                name="role"
                class="h-11 rounded-xl border border-slate-200 bg-slate-50 px-4 text-sm text-slate-700 outline-none transition focus:border-[#72ad28] focus:bg-white focus:ring-4 focus:ring-[#72ad28]/10"
            >

                <option value="">
                    Semua Role
                </option>

                <option
                    value="user"
                    @selected(request('role') === 'user')
                >
                    User
                </option>

                <option
                    value="admin_bank_sampah"
                    @selected(request('role') === 'admin_bank_sampah')
                >
                    Admin Bank Sampah
                </option>

                <option
                    value="super_admin"
                    @selected(request('role') === 'super_admin')
                >
                    Super Admin
                </option>

            </select>


            {{-- Filter Button --}}
            <button
                type="submit"
                class="inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-slate-800 px-6 text-sm font-semibold text-white transition hover:bg-slate-700"
            >

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M3 5h18M6 12h12M10 19h4"
                    />
                </svg>

                Terapkan

            </button>

        </form>

    </div>


    {{-- ============================================================
        ACCOUNT TABLE
    ============================================================= --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        {{-- Table Header --}}
        <div class="flex flex-col gap-2 border-b border-slate-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">

            <div>

                <h2 class="font-semibold text-slate-800">
                    Semua Akun
                </h2>

                <p class="mt-0.5 text-xs text-slate-500">

                    Menampilkan

                    <span class="font-medium text-slate-700">
                        {{ $users->firstItem() ?? 0 }}
                    </span>

                    -

                    <span class="font-medium text-slate-700">
                        {{ $users->lastItem() ?? 0 }}
                    </span>

                    dari

                    <span class="font-medium text-slate-700">
                        {{ $users->total() }}
                    </span>

                    akun

                </p>

            </div>

        </div>


        {{-- Responsive Table --}}
        <div class="overflow-x-auto">

            <table class="w-full min-w-[900px]">

                {{-- Table Head --}}
                <thead>

                    <tr class="border-b border-slate-100 bg-slate-50/70">

                        <th class="px-6 py-4 text-left text-[11px] font-bold uppercase tracking-wider text-slate-500">
                            Akun
                        </th>

                        <th class="px-6 py-4 text-left text-[11px] font-bold uppercase tracking-wider text-slate-500">
                            Role
                        </th>

                        <th class="px-6 py-4 text-left text-[11px] font-bold uppercase tracking-wider text-slate-500">
                            Bank Sampah
                        </th>

                        <th class="px-6 py-4 text-left text-[11px] font-bold uppercase tracking-wider text-slate-500">
                            Terdaftar
                        </th>

                        <th class="px-6 py-4 text-right text-[11px] font-bold uppercase tracking-wider text-slate-500">
                            Aksi
                        </th>

                    </tr>

                </thead>


                {{-- Table Body --}}
                <tbody class="divide-y divide-slate-100">

                    @forelse($users as $user)

                        <tr class="group transition duration-150 hover:bg-slate-50/70">

                            {{-- Account --}}
                            <td class="px-6 py-4">

                                <div class="flex items-center gap-3">

                                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#edf8dc] text-sm font-bold text-[#5d951e]">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </div>

                                    <div class="min-w-0">

                                        <p class="truncate text-sm font-semibold text-slate-800">
                                            {{ $user->name }}
                                        </p>

                                        <p class="mt-0.5 truncate text-xs text-slate-500">
                                            {{ $user->email }}
                                        </p>

                                    </div>

                                </div>

                            </td>


                            {{-- Role --}}
                            <td class="px-6 py-4">

                                @if($user->role === 'super_admin')

                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-violet-50 px-3 py-1.5 text-xs font-semibold text-violet-700">

                                        <span class="h-1.5 w-1.5 rounded-full bg-violet-500"></span>

                                        Super Admin

                                    </span>

                                @elseif($user->role === 'admin_bank_sampah')

                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-700">

                                        <span class="h-1.5 w-1.5 rounded-full bg-blue-500"></span>

                                        Admin Bank Sampah

                                    </span>

                                @else

                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-700">

                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>

                                        User

                                    </span>

                                @endif

                            </td>


                            {{-- Bank Sampah --}}
                            <td class="px-6 py-4">

                                @if($user->bankSampah)

                                    <div class="flex items-center gap-2">

                                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-slate-100 text-slate-500">

                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="h-4 w-4"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                                stroke-width="1.8"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M3 21h18M5 21V9l7-5 7 5v12M9 21v-6h6v6"
                                                />
                                            </svg>

                                        </div>

                                        <span class="max-w-[220px] truncate text-sm text-slate-700">
                                            {{ $user->bankSampah->name }}
                                        </span>

                                    </div>

                                @else

                                    <span class="text-sm text-slate-400">
                                        Tidak terhubung
                                    </span>

                                @endif

                            </td>


                            {{-- Created At --}}
                            <td class="px-6 py-4">

                                <div>

                                    <p class="text-sm font-medium text-slate-700">
                                        {{ $user->created_at?->format('d M Y') }}
                                    </p>

                                    <p class="mt-0.5 text-xs text-slate-400">
                                        {{ $user->created_at?->format('H:i') }}
                                    </p>

                                </div>

                            </td>


                            {{-- Actions --}}
                            <td class="px-6 py-4">

                                <div class="flex justify-end gap-2">

                                    {{-- Edit --}}
                                    <a
                                        href="{{ route('admin.users.edit', $user) }}"
                                        class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600"
                                        title="Edit akun"
                                    >

                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="h-4 w-4"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="m16.862 4.487 1.687-1.688a2.25 2.25 0 1 1 3.182 3.182l-8.844 8.844a2.25 2.25 0 0 1-1.007.57l-3.24.81.81-3.24a2.25 2.25 0 0 1 .57-1.007l6.842-6.842Z"
                                            />

                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M19.5 7.5 16.5 4.5"
                                            />
                                        </svg>

                                    </a>


                                    {{-- Delete --}}
                                    @if(
                                        $user->id !== auth()->id()
                                        && $user->role !== 'super_admin'
                                    )

                                        <form
                                            action="{{ route('admin.users.destroy', $user) }}"
                                            method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun {{ $user->name }}?')"
                                        >

                                            @csrf

                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 transition hover:border-red-200 hover:bg-red-50 hover:text-red-600"
                                                title="Hapus akun"
                                            >

                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    class="h-4 w-4"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke="currentColor"
                                                    stroke-width="1.8"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M6 7h12m-10 0v12a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2V7m-7 0V5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2"
                                                    />
                                                </svg>

                                            </button>

                                        </form>

                                    @else

                                        {{-- Protected Account --}}
                                        <span
                                            class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-slate-100 bg-slate-50 text-slate-300"
                                            title="Akun tidak dapat dihapus"
                                        >

                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="h-4 w-4"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                                stroke-width="1.8"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M12 9v4m0 4h.01M10.29 3.86 2.82 17a2 2 0 0 0 1.74 3h14.88a2 2 0 0 0 1.74-3L13.71 3.86a2 2 0 0 0-3.42 0Z"
                                                />
                                            </svg>

                                        </span>

                                    @endif

                                </div>

                            </td>

                        </tr>


                    @empty

                        {{-- Empty State --}}
                        <tr>

                            <td
                                colspan="5"
                                class="px-6 py-16 text-center"
                            >

                                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100">

                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-7 w-7 text-slate-400"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M15 19a3 3 0 1 0-6 0m9-8a6 6 0 1 1-12 0 6 6 0 0 1 12 0Z"
                                        />
                                    </svg>

                                </div>

                                <p class="mt-4 text-sm font-semibold text-slate-700">
                                    Tidak ada akun ditemukan
                                </p>

                                <p class="mt-1 text-sm text-slate-500">
                                    Coba ubah kata pencarian atau filter role.
                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- Pagination --}}
        @if($users->hasPages())

            <div class="border-t border-slate-100 px-5 py-4 sm:px-6">

                {{ $users->links() }}

            </div>

        @endif

    </div>

</div>
@endsection