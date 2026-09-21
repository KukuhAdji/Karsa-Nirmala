<?php

namespace App\Http\Controllers;

use App\Models\MarketplaceProduct;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminMarketplaceController extends Controller
{
    public function index(Request $request): View
    {
        $bankSampah = $request->user()->bankSampah()->firstOrFail();
        $products = MarketplaceProduct::where('bank_sampah_id', $bankSampah->id)
            ->latest()
            ->get();

        return view('admin_banksampah.marketplace', compact('bankSampah', 'products'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatedProduct($request, true);
        $validated['bank_sampah_id'] = $request->user()->bank_sampah_id;
        $validated['image'] = $request->file('image')->store('marketplace', 'public');

        MarketplaceProduct::create($validated);

        return back()->with('success', 'Produk berhasil ditambahkan ke katalog.');
    }

    public function update(Request $request, MarketplaceProduct $product): RedirectResponse
    {
        $this->ensureOwnership($request, $product);
        $validated = $this->validatedProduct($request);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('marketplace', 'public');
            $this->deleteStoredImage($product->image);
        }

        $product->update($validated);

        return back()->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Request $request, MarketplaceProduct $product): RedirectResponse
    {
        $this->ensureOwnership($request, $product);
        $this->deleteStoredImage($product->image);
        $product->delete();

        return back()->with('success', 'Produk berhasil dihapus dari katalog.');
    }

    private function validatedProduct(Request $request, bool $imageRequired = false): array
    {
        $rules = [
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'price' => ['required', 'integer', 'min:0'],
            'image' => [$imageRequired ? 'required' : 'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'category' => ['nullable', 'string', 'max:100'],
            'stock' => ['required', 'integer', 'min:0'],
            'status' => ['required', 'in:Tersedia,Discontinued'],
        ];

        $validated = $request->validate($rules);
        unset($validated['image']);

        return $validated;
    }

    private function deleteStoredImage(?string $image): void
    {
        if ($image && !preg_match('/^https?:\/\//i', $image)) {
            Storage::disk('public')->delete($image);
        }
    }

    private function ensureOwnership(Request $request, MarketplaceProduct $product): void
    {
        abort_unless(
            (int) $product->bank_sampah_id === (int) $request->user()->bank_sampah_id,
            403,
            'Produk tersebut bukan milik bank sampah Anda.'
        );
    }
}
