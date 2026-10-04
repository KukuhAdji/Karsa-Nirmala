<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BankSampah;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class BankSampahController extends Controller
{
    /**
     * Menampilkan seluruh Bank Sampah.
     */
    public function index(Request $request): View
    {
        $query = BankSampah::query();

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */
        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where(
                    'name',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'address',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'whatsapp',
                    'like',
                    "%{$search}%"
                );

            });
        }


        /*
        |--------------------------------------------------------------------------
        | Filter Status
        |--------------------------------------------------------------------------
        */
        if ($request->filled('status')) {

            $query->where(
                'status',
                $request->status
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */
        $bankSampahs = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | Statistik
        |--------------------------------------------------------------------------
        */
        $totalBankSampah = BankSampah::count();

        $bankSampahBuka = BankSampah::where(
            'status',
            'Buka'
        )->count();

        $bankSampahTutup = BankSampah::where(
            'status',
            'Tutup'
        )->count();


        return view(
            'admin.bank-sampah.index',
            compact(
                'bankSampahs',
                'totalBankSampah',
                'bankSampahBuka',
                'bankSampahTutup'
            )
        );
    }


    /**
     * Menampilkan form tambah Bank Sampah.
     */
    public function create(): View
    {
        return view(
            'admin.bank-sampah.create'
        );
    }


    /**
     * Menyimpan Bank Sampah baru.
     */
    public function store(
        Request $request
    ): RedirectResponse {

        /*
        |--------------------------------------------------------------------------
        | Validasi
        |--------------------------------------------------------------------------
        */
        $validated = $request->validate([

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'address' => [
                'required',
                'string',
            ],

            'latitude' => [
                'required',
                'numeric',
                'between:-90,90',
            ],

            'longitude' => [
                'required',
                'numeric',
                'between:-180,180',
            ],

            'qris_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'whatsapp' => [
                'nullable',
                'string',
                'max:30',
            ],

            'status' => [
                'required',
                Rule::in([
                    'Buka',
                    'Tutup',
                ]),
            ],

            'waste_type' => [
                'nullable',
                'string',
                'max:255',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | Upload QRIS
        |--------------------------------------------------------------------------
        */
        if ($request->hasFile('qris_image')) {

            $validated['qris_image'] =
                $request
                    ->file('qris_image')
                    ->store(
                        'qris',
                        'public'
                    );

        }


        /*
        |--------------------------------------------------------------------------
        | Simpan Bank Sampah
        |--------------------------------------------------------------------------
        */
        BankSampah::create(
            $validated
        );


        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */
        return redirect()
            ->route('admin.manage-bank-sampah.index')
            ->with(
                'success',
                'Bank Sampah berhasil ditambahkan.'
            );
    }


    /**
     * Menampilkan form edit Bank Sampah.
     */
    public function edit(
        BankSampah $bankSampah
    ): View {

        return view(
            'admin.bank-sampah.edit',
            compact('bankSampah')
        );
    }


    /**
     * Memperbarui Bank Sampah.
     */
    public function update(
        Request $request,
        BankSampah $bankSampah
    ): RedirectResponse {

        /*
        |--------------------------------------------------------------------------
        | Validasi
        |--------------------------------------------------------------------------
        */
        $validated = $request->validate([

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'address' => [
                'required',
                'string',
            ],

            'latitude' => [
                'required',
                'numeric',
                'between:-90,90',
            ],

            'longitude' => [
                'required',
                'numeric',
                'between:-180,180',
            ],

            'qris_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'whatsapp' => [
                'nullable',
                'string',
                'max:30',
            ],

            'status' => [
                'required',
                Rule::in([
                    'Buka',
                    'Tutup',
                ]),
            ],

            'waste_type' => [
                'nullable',
                'string',
                'max:255',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | QRIS
        |--------------------------------------------------------------------------
        |
        | Jika admin mengupload QRIS baru:
        |
        | 1. Simpan path QRIS lama.
        | 2. Upload QRIS baru.
        | 3. Simpan path QRIS baru.
        | 4. Hapus QRIS lama dari storage.
        |
        | Jika tidak ada QRIS baru:
        |
        | QRIS lama tetap digunakan.
        |
        */
        if ($request->hasFile('qris_image')) {

            /*
            |--------------------------------------------------------------------------
            | Simpan path QRIS lama
            |--------------------------------------------------------------------------
            */
            $oldQris = $bankSampah->qris_image;


            /*
            |--------------------------------------------------------------------------
            | Upload QRIS baru
            |--------------------------------------------------------------------------
            */
            $newQris = $request
                ->file('qris_image')
                ->store(
                    'qris',
                    'public'
                );


            /*
            |--------------------------------------------------------------------------
            | Simpan path QRIS baru ke data update
            |--------------------------------------------------------------------------
            */
            $validated['qris_image'] = $newQris;


            /*
            |--------------------------------------------------------------------------
            | Hapus QRIS lama
            |--------------------------------------------------------------------------
            |
            | Hanya hapus jika:
            | - memang terdapat QRIS lama
            | - file tersebut benar-benar ada
            |
            */
            if (
                !empty($oldQris)
                && Storage::disk('public')->exists($oldQris)
            ) {

                Storage::disk('public')->delete(
                    $oldQris
                );

            }

        } else {

            /*
            |--------------------------------------------------------------------------
            | Tidak ada QRIS baru
            |--------------------------------------------------------------------------
            |
            | Jangan mengubah kolom qris_image.
            |
            */
            unset(
                $validated['qris_image']
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Update Bank Sampah
        |--------------------------------------------------------------------------
        */
        $bankSampah->update(
            $validated
        );


        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */
        return redirect()
            ->route('admin.manage-bank-sampah.index')
            ->with(
                'success',
                'Bank Sampah berhasil diperbarui.'
            );
    }


    /**
     * Menghapus Bank Sampah.
     */
    public function destroy(
        BankSampah $bankSampah
    ): RedirectResponse {

        /*
        |--------------------------------------------------------------------------
        | Cegah penghapusan jika masih memiliki Admin Bank Sampah
        |--------------------------------------------------------------------------
        */
        $hasAdmin = User::where(
            'bank_sampah_id',
            $bankSampah->id
        )->exists();


        if ($hasAdmin) {

            return back()->with(
                'error',
                'Bank Sampah tidak dapat dihapus karena masih memiliki Admin Bank Sampah.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Hapus QRIS dari storage jika ada
        |--------------------------------------------------------------------------
        */
        if (
            !empty($bankSampah->qris_image)
            && Storage::disk('public')->exists(
                $bankSampah->qris_image
            )
        ) {

            Storage::disk('public')->delete(
                $bankSampah->qris_image
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Hapus data Bank Sampah
        |--------------------------------------------------------------------------
        */
        $bankSampah->delete();


        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */
        return redirect()
            ->route('admin.manage-bank-sampah.index')
            ->with(
                'success',
                'Bank Sampah berhasil dihapus.'
            );
    }
}
