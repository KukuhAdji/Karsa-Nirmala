<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BankSampah;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Menampilkan daftar seluruh akun.
     */
    public function index(Request $request): View
    {
        $query = User::with('bankSampah');

        /*
        |--------------------------------------------------------------------------
        | Search berdasarkan nama atau email
        |--------------------------------------------------------------------------
        */
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Filter berdasarkan role
        |--------------------------------------------------------------------------
        */
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */
        $users = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'admin.users.index',
            compact('users')
        );
    }


    /**
     * Menampilkan form tambah akun.
     */
    public function create(): View
    {
        $bankSampahs = BankSampah::orderBy('name')->get();

        return view(
            'admin.users.create',
            compact('bankSampahs')
        );
    }


    /**
     * Menyimpan akun baru.
     */
    public function store(Request $request): RedirectResponse
    {
        /*
        |--------------------------------------------------------------------------
        | Validasi input
        |--------------------------------------------------------------------------
        */
        $validated = $request->validate([

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],

            'role' => [
                'required',
                Rule::in([
                    'user',
                    'admin_bank_sampah',
                    'super_admin',
                ]),
            ],

            'bank_sampah_id' => [
                'nullable',
                'exists:bank_sampahs,id',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | Validasi khusus Admin Bank Sampah
        |--------------------------------------------------------------------------
        |
        | Jika role adalah admin_bank_sampah,
        | maka akun wajib terhubung dengan Bank Sampah.
        |
        */
        if (
            $validated['role'] === 'admin_bank_sampah'
            && empty($validated['bank_sampah_id'])
        ) {
            return back()
                ->withErrors([
                    'bank_sampah_id' =>
                        'Admin Bank Sampah harus memiliki Bank Sampah.',
                ])
                ->withInput();
        }


        /*
        |--------------------------------------------------------------------------
        | User dan Super Admin tidak terhubung ke Bank Sampah tertentu
        |--------------------------------------------------------------------------
        */
        if ($validated['role'] !== 'admin_bank_sampah') {
            $validated['bank_sampah_id'] = null;
        }


        /*
        |--------------------------------------------------------------------------
        | Hash password
        |--------------------------------------------------------------------------
        |
        | Password TIDAK boleh disimpan dalam bentuk plaintext.
        |
        */
        $validated['password'] = Hash::make(
            $validated['password']
        );


        /*
        |--------------------------------------------------------------------------
        | Simpan akun
        |--------------------------------------------------------------------------
        */
        User::create($validated);


        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */
        return redirect()
            ->route('admin.users.index')
            ->with(
                'success',
                'Akun berhasil ditambahkan.'
            );
    }


    /**
     * Menampilkan form edit akun.
     */
    public function edit(User $user): View
    {
        $bankSampahs = BankSampah::orderBy('name')->get();

        return view(
            'admin.users.edit',
            compact(
                'user',
                'bankSampahs'
            )
        );
    }


    /**
     * Memperbarui akun.
     */
    public function update(
        Request $request,
        User $user
    ): RedirectResponse {

        /*
        |--------------------------------------------------------------------------
        | Validasi input
        |--------------------------------------------------------------------------
        */
        $validated = $request->validate([

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique(
                    'users',
                    'email'
                )->ignore($user->id),
            ],

            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],

            'role' => [
                'required',
                Rule::in([
                    'user',
                    'admin_bank_sampah',
                    'super_admin',
                ]),
            ],

            'bank_sampah_id' => [
                'nullable',
                'exists:bank_sampahs,id',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | Lindungi role Super Admin yang sedang login
        |--------------------------------------------------------------------------
        |
        | Super Admin tetap dapat mengubah:
        | - Nama
        | - Email
        | - Password
        |
        | Tetapi tidak dapat mengubah role dirinya sendiri.
        |
        */
        if (
            $user->id === auth()->id()
            && $user->role === 'super_admin'
            && $validated['role'] !== 'super_admin'
        ) {
            return back()
                ->withErrors([
                    'role' =>
                        'Role akun Super Admin yang sedang digunakan tidak dapat diubah.',
                ])
                ->withInput();
        }


        /*
        |--------------------------------------------------------------------------
        | Validasi khusus Admin Bank Sampah
        |--------------------------------------------------------------------------
        |
        | Jika role adalah admin_bank_sampah,
        | maka akun wajib memiliki Bank Sampah.
        |
        */
        if (
            $validated['role'] === 'admin_bank_sampah'
            && empty($validated['bank_sampah_id'])
        ) {
            return back()
                ->withErrors([
                    'bank_sampah_id' =>
                        'Admin Bank Sampah harus memiliki Bank Sampah.',
                ])
                ->withInput();
        }


        /*
        |--------------------------------------------------------------------------
        | User dan Super Admin tidak terhubung ke Bank Sampah tertentu
        |--------------------------------------------------------------------------
        */
        if ($validated['role'] !== 'admin_bank_sampah') {
            $validated['bank_sampah_id'] = null;
        }


        /*
        |--------------------------------------------------------------------------
        | Password
        |--------------------------------------------------------------------------
        |
        | Jika password dikosongkan saat edit,
        | password lama tetap dipertahankan.
        |
        | Jika password diisi,
        | password baru akan di-hash.
        |
        */
        if (!empty($validated['password'])) {

            $validated['password'] = Hash::make(
                $validated['password']
            );

        } else {

            unset($validated['password']);

        }


        /*
        |--------------------------------------------------------------------------
        | Simpan perubahan
        |--------------------------------------------------------------------------
        */
        $user->update($validated);


        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */
        return redirect()
            ->route('admin.users.index')
            ->with(
                'success',
                'Akun berhasil diperbarui.'
            );
    }


    /**
     * Menghapus akun.
     */
    public function destroy(User $user): RedirectResponse
    {
        /*
        |--------------------------------------------------------------------------
        | Jangan izinkan menghapus akun yang sedang login
        |--------------------------------------------------------------------------
        */
        if ($user->id === auth()->id()) {

            return back()->with(
                'error',
                'Akun yang sedang digunakan tidak dapat dihapus.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Lindungi akun Super Admin
        |--------------------------------------------------------------------------
        */
        if ($user->role === 'super_admin') {

            return back()->with(
                'error',
                'Akun Super Admin tidak dapat dihapus melalui halaman ini.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Hapus akun
        |--------------------------------------------------------------------------
        */
        $user->delete();


        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */
        return redirect()
            ->route('admin.users.index')
            ->with(
                'success',
                'Akun berhasil dihapus.'
            );
    }
}