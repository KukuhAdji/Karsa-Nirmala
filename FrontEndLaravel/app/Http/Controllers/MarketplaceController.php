<?php

namespace App\Http\Controllers;

use App\Models\MarketplaceOrder;
use App\Models\MarketplaceProduct;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MarketplaceController extends Controller
{
    public function index(): View
    {
        $catalogProducts = MarketplaceProduct::with('bankSampah')
            ->where('status', 'Tersedia')
            ->latest()
            ->get()
            ->map(fn (MarketplaceProduct $product): array => [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description ?? '',
                'price' => $product->price,
                'image' => $product->image
                    ? (preg_match('/^https?:\/\//i', $product->image)
                        ? $product->image
                        : asset('storage/' . $product->image))
                    : asset('images/karsa-nirmala-logo.png'),
                'bank_sampah' => $product->bankSampah?->name ?? 'Bank Sampah',
                'bank_sampah_id' => $product->bank_sampah_id,
                'category' => $product->category ?? 'Lainnya',
                'status' => $product->status,
                'stock' => $product->stock,
            ])
            ->all();

        return view('dashboard.marketplace', ['products' => $catalogProducts]);
    }

    public function show(MarketplaceProduct $product): View
    {
        abort_unless($product->status === 'Tersedia', 404);

        return view('dashboard.marketplace-detail', compact('product'));
    }

    public function buy(Request $request, MarketplaceProduct $product): RedirectResponse
    {
        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'min:2', 'max:255'],
            'customer_phone' => ['required', 'string', 'min:8', 'max:30'],
            'shipping_address' => ['required', 'string', 'min:10', 'max:2000'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $order = DB::transaction(function () use ($product, $validated, $request): MarketplaceOrder {
            $lockedProduct = MarketplaceProduct::whereKey($product->id)->lockForUpdate()->firstOrFail();

            if ($lockedProduct->status !== 'Tersedia' || $validated['quantity'] > $lockedProduct->stock) {
                abort(422, 'Stok produk tidak mencukupi.');
            }

            $order = MarketplaceOrder::create([
                'user_id' => $request->user()->id,
                'marketplace_product_id' => $lockedProduct->id,
                'customer_name' => $validated['customer_name'],
                'customer_phone' => $validated['customer_phone'],
                'shipping_address' => $validated['shipping_address'],
                'quantity' => $validated['quantity'],
                'unit_price' => $lockedProduct->price,
                'total_price' => $lockedProduct->price * $validated['quantity'],
                'status' => 'Menunggu pembayaran',
            ]);

            $lockedProduct->decrement('stock', $validated['quantity']);

            return $order;
        });

        return redirect()->route('marketplace.payment', $order);
    }

    public function payment(Request $request, MarketplaceOrder $order): View
    {
        abort_unless((int) $order->user_id === (int) $request->user()->id, 403);

        $order->load(['product.bankSampah']);

        return view('dashboard.marketplace-payment', compact('order'));
    }

    public function uploadPaymentProof(Request $request, MarketplaceOrder $order): RedirectResponse
    {
        abort_unless((int) $order->user_id === (int) $request->user()->id, 403);

        $request->validate([
            'payment_proof' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        $proof = $request->file('payment_proof')->store('payment-proofs', 's3');
        if ($order->payment_proof) {
            Storage::disk('s3')->delete($order->payment_proof);
        }

        $order->update([
            'payment_proof' => $proof,
            'status' => 'Menunggu verifikasi pembayaran',
        ]);

        return back()->with('success', 'Bukti pembayaran berhasil dikirim ke bank sampah.');
    }
}
