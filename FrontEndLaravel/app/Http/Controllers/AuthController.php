<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

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

        return redirect()->intended(route('dashboard'))
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