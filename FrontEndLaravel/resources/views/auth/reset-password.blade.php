<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - {{ config('app.name', 'Karsa Nirmala') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-lime-50 via-white to-green-100 flex items-center justify-center p-6">
    <main class="bg-white shadow-2xl rounded-[32px] p-8 w-full max-w-md">
        <h1 class="text-3xl font-black mb-2">Choose a new password</h1>
        <p class="text-slate-500 mb-6">Enter the email address for your account and your new password.</p>

        @if ($errors->getBag('resetPassword')->any())
            <div class="mb-5 bg-red-100 border border-red-300 text-red-700 p-4 rounded-xl" role="alert">
                @foreach ($errors->getBag('resetPassword')->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div>
                <label for="email" class="block font-semibold mb-2">Email Address</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email', $email) }}"
                    required
                    autocomplete="email"
                    class="w-full border rounded-xl p-4"
                >
            </div>

            <div>
                <label for="password" class="block font-semibold mb-2">New Password</label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    minlength="6"
                    autocomplete="new-password"
                    class="w-full border rounded-xl p-4"
                >
            </div>

            <div>
                <label for="password_confirmation" class="block font-semibold mb-2">Confirm New Password</label>
                <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    required
                    minlength="6"
                    autocomplete="new-password"
                    class="w-full border rounded-xl p-4"
                >
            </div>

            <button type="submit" class="w-full bg-lime-500 hover:bg-lime-600 text-white py-4 rounded-xl font-bold transition">
                Reset Password
            </button>
        </form>

        <a href="{{ route('login') }}" class="block text-center text-lime-700 font-semibold mt-5">Back to login</a>
    </main>
</body>
</html>
