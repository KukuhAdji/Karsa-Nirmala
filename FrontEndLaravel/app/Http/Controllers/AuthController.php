<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login', ['showRegister' => true]);
    }

    public function sendResetLink(Request $request)
    {
        $request->validateWithBag('forgotPassword', [
            'email' => 'required|email',
        ]);

        if ($this->allowsLocalPasswordReset($request)) {
            $user = User::where('email', $request->input('email'))->first();

            if (!$user) {
                return back()
                    ->withInput($request->only('email'))
                    ->withErrors([
                        'email' => 'Tidak ada akun dengan email tersebut.',
                    ], 'forgotPassword');
            }

            $request->session()->put('local_password_reset_email', $user->email);

            return redirect()->route('password.local-reset.form');
        }

        $status = Password::sendResetLink($request->only('email'));

        return back()
            ->withInput($request->only('email'))
            ->with('resetStatus', __($status));
    }

    public function showLocalResetForm(Request $request)
    {
        abort_unless($this->allowsLocalPasswordReset($request), 404);

        $email = $request->session()->get('local_password_reset_email');
        abort_unless($email && User::where('email', $email)->exists(), 404);

        return view('auth.local-reset-password', ['email' => $email]);
    }

    public function resetLocalPassword(Request $request)
    {
        abort_unless($this->allowsLocalPasswordReset($request), 404);

        $email = $request->session()->get('local_password_reset_email');
        abort_unless($email, 404);

        $validated = $request->validateWithBag('resetPassword', [
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::where('email', $email)->first();

        if (!$user) {
            $request->session()->forget('local_password_reset_email');

            return redirect()->route('login')
                ->withErrors(['email' => 'Akun tidak lagi tersedia.'], 'login');
        }

        $user->forceFill([
            'password' => Hash::make($validated['password']),
            'remember_token' => Str::random(60),
        ])->save();

        $request->session()->forget('local_password_reset_email');

        return redirect()->route('login')
            ->with('success', 'Password berhasil diubah. Silakan masuk dengan password baru.');
    }

    public function showResetForm(Request $request, string $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validateWithBag('resetPassword', [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password): void {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('success', __($status));
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => __($status)], 'resetPassword');
    }

    private function allowsLocalPasswordReset(Request $request): bool
    {
        return app()->environment('local')
            && in_array(strtolower($request->getHost()), ['localhost', '127.0.0.1', '::1'], true)
            && in_array($request->ip(), ['127.0.0.1', '::1'], true);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Attempt authentication
        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors([
                    'email' => 'Email atau password yang Anda masukkan salah.'
                ], 'login');
        }

        // Regenerate session
        $request->session()->regenerate();

        // Force session to be written
        Session::save();

        // Get the authenticated user
        $user = Auth::user();
        if (!$user) {
            Auth::logout();
            return back()
                ->withInput($request->only('email'))
                ->withErrors([
                    'email' => 'Terjadi kesalahan. Silakan coba lagi.'
                ], 'login');
        }

        // Log successful login
        \Log::info('User login successful: ' . $user->email);

        $destination = $user->role === 'admin_bank_sampah'
            ? route('admin.bank-sampah.dashboard')
            : route('dashboard');

        return redirect()->intended($destination)
            ->with('success', 'Login berhasil! Selamat datang.');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed'
        ]);

        try {
            // Create user
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password'])
            ]);

            // Login user
            Auth::login($user);
            
            // Regenerate session
            $request->session()->regenerate();

            // Force session to be written
            Session::save();

            \Log::info('User registered and logged in: ' . $user->email);

            return redirect()->route('dashboard')
                ->with('success', 'Akun berhasil dibuat! Selamat datang.');
        } catch (\Exception $e) {
            \Log::error('Registration error: ' . $e->getMessage());
            
            return back()
                ->withInput($request->only('name', 'email'))
                ->withErrors([
                    'email' => 'Terjadi kesalahan saat membuat akun. Silakan coba lagi.'
                ]);
        }
    }

    public function logout(Request $request)
    {
        $email = Auth::user()?->email;
        
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($email) {
            \Log::info('User logged out: ' . $email);
        }

        return redirect('/')->with('success', 'Anda berhasil logout.');
    }
}