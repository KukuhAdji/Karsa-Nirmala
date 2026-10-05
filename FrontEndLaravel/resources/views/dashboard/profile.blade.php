@extends('layouts.app')

@section('content')

<div class="max-w-4xl">

    <h1 class="text-4xl font-black mb-8">
        Profile Settings
    </h1>

    <div class="bg-white rounded-3xl border p-8">

        <div class="flex items-center gap-6 mb-10">

            <img
                src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'User') }}"
                alt="Profile avatar"
                class="w-28 h-28 rounded-full">

            <div>

                <h2 class="text-3xl font-black">
                    {{ Auth::user()->name ?? 'User' }}
                </h2>

                <p class="text-slate-500">
                    {{ Auth::user()->email ?? 'email@example.com' }}
                </p>

            </div>

        </div>

        @if (session('success'))
            <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-semibold text-green-800" role="status">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800" role="alert">
                <p class="font-bold">Profil belum dapat diperbarui:</p>
                <ul class="mt-2 list-inside list-disc space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>

                <label for="name" class="font-bold">
                    Full Name
                </label>

                <input
                    id="name"
                    type="text"
                    name="name"
                    value="{{ old('name', Auth::user()->name) }}"
                    autocomplete="name"
                    required
                    class="w-full border rounded-xl mt-2 p-4">

            </div>

            <div>

                <label for="email" class="font-bold">
                    Email Address
                </label>

                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email', Auth::user()->email) }}"
                    autocomplete="email"
                    required
                    class="w-full border rounded-xl mt-2 p-4">

            </div>

            <div>

                <label for="password" class="font-bold">
                    New Password
                </label>

                <input
                    id="password"
                    type="password"
                    name="password"
                    autocomplete="new-password"
                    minlength="8"
                    class="w-full border rounded-xl mt-2 p-4">

                <p class="mt-2 text-sm text-slate-500">
                    Leave blank to keep your current password. Use at least 8 characters to change it.
                </p>

            </div>

            <div>

                <label for="password_confirmation" class="font-bold">
                    Confirm New Password
                </label>

                <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    autocomplete="new-password"
                    minlength="8"
                    class="w-full border rounded-xl mt-2 p-4">

            </div>

            <button
                type="submit"
                class="bg-lime-500 text-white px-8 py-4 rounded-xl font-bold">

                Save Changes

            </button>

        </form>

    </div>

</div>

@endsection
