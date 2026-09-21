<?php

namespace App\Http\Controllers;

use App\Models\MarketplaceOrder;
use App\Models\MarketplaceProduct;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class MarketplaceController extends Controller
{
    public function index(): View
    {
        // Dummy data untuk produk marketplace
        $products = [
            [
                'id' => 1,
                'name' => 'Tas Tangan Ramah Lingkungan',
                'description' => 'Tas tangan berkualitas tinggi dari bahan daur ulang',
                'price' => 125000,
                'image' => 'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?w=500&h=500&fit=crop',
                'bank_sampah' => 'Bank Sampah Induk Surabaya',
                'bank_sampah_id' => 1,
                'rating' => 4.8,
                'reviews' => 42,
                'category' => 'Fashion',
                'status' => 'Tersedia',
                'stock' => 15
            ],
            [
                'id' => 2,
                'name' => 'Tempat Pensil Kreatif',
                'description' => 'Tempat pensil unik dari plastik bekas yang didaur ulang',
                'price' => 45000,
                'image' => asset('images/tempat-pensil-bekas.jpeg'),
                'bank_sampah' => 'Bank Sampah Manyar Mandiri',
                'bank_sampah_id' => 2,
                'rating' => 4.6,
                'reviews' => 28,
                'category' => 'Stationery',
                'status' => 'Tersedia',
                'stock' => 24
            ],
            [
                'id' => 3,
                'name' => 'Botol Minum Ramah Lingkungan',
                'description' => 'Botol minum eco-friendly dari bahan daur ulang premium',
                'price' => 85000,
                'image' => asset('images/botol-minum-ramah-lingkungan.jpg'),
                'bank_sampah' => 'Bank Sampah Lestari',
                'bank_sampah_id' => 3,
                'rating' => 4.9,
                'reviews' => 67,
                'category' => 'Lifestyle',
                'status' => 'Tersedia',
                'stock' => 32
            ],
            [
                'id' => 4,
                'name' => 'Dompet Dari Bahan Plastik Bekas',
                'description' => 'Dompet minimalis dengan desain modern dari plastik daur ulang',
                'price' => 65000,
                'image' => asset('images/dompet-plastik.jpg'),
                'bank_sampah' => 'Bank Sampah MARKISA',
                'bank_sampah_id' => 4,
                'rating' => 4.7,
                'reviews' => 35,
                'category' => 'Accessories',
                'status' => 'Tersedia',
                'stock' => 18
            ],
            [
                'id' => 5,
                'name' => 'Tas Belanja Kain Daur Ulang',
                'description' => 'Tas belanja multifungsi dari kain bekas yang diproses ulang',
                'price' => 95000,
                'image' => asset('images/tas-belanja-kain-daur ulang.jpg'),
                'bank_sampah' => 'Bank Sampah CEMPAKA',
                'bank_sampah_id' => 5,
                'rating' => 4.5,
                'reviews' => 22,
                'category' => 'Fashion',
                'status' => 'Tersedia',
                'stock' => 12
            ],
            [
                'id' => 6,
                'name' => 'Hiasan Dinding Unik',
                'description' => 'Hiasan dinding kreatif dari limbah logam dan kaca daur ulang',
                'price' => 150000,
                'image' => asset('images/hiasan-dinding-daur ulang.jpg'),
                'bank_sampah' => 'Bank Sampah SAMAS',
                'bank_sampah_id' => 6,
                'rating' => 4.8,
                'reviews' => 51,
                'category' => 'Home Decor',
                'status' => 'Tersedia',
                'stock' => 8
            ],
            [
                'id' => 7,
                'name' => 'Jam Tangan Handmade',
                'description' => 'Jam tangan custom dari komponen elektronik bekas yang dikerjakan ulang',
                'price' => 175000,
                'image' => 'https://images.unsplash.com/photo-1523170335258-f5ed11844a49?w=500&h=500&fit=crop',
                'bank_sampah' => 'Bank Sampah BAROKAH',
                'bank_sampah_id' => 7,
                'rating' => 4.9,
                'reviews' => 45,
                'category' => 'Accessories',
                'status' => 'Tersedia',
                'stock' => 6
            ],
            [
                'id' => 8,
                'name' => 'Pot Tanaman Ramah Lingkungan',
                'description' => 'Pot tanaman berkualitas dari bahan plastik dan keramik bekas',
                'price' => 55000,
                'image' => asset('images/pot-tanaman-ramah-lingkungan.jpg'),
                'bank_sampah' => 'Bank Sampah Ngagel Sejahtera',
                'bank_sampah_id' => 8,
                'rating' => 4.6,
                'reviews' => 19,
                'category' => 'Gardening',
                'status' => 'Tersedia',
                'stock' => 28
            ],
            [
                'id' => 9,
                'name' => 'Lampu Hias Minimalis',
                'description' => 'Lampu hias unik dengan desain minimalis dari bahan bekas',
                'price' => 135000,
                'image' => 'https://images.unsplash.com/photo-1565308499705-6f4ee54688ae?w=500&h=500&fit=crop',
                'bank_sampah' => 'Bank Sampah Botol Bekas / Bioichi',
                'bank_sampah_id' => 9,
                'rating' => 4.7,
                'reviews' => 38,
                'category' => 'Home Decor',
                'status' => 'Tersedia',
                'stock' => 11
            ],
            [
                'id' => 10,
                'name' => 'Sandal Nyaman Dari Bahan Bekas',
                'description' => 'Sandal kasual dengan bantalan empuk dari material daur ulang',
                'price' => 75000,
                'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=500&h=500&fit=crop',
                'bank_sampah' => 'Bank Sampah Induk Berkah Sukomanunggal',
                'bank_sampah_id' => 10,
                'rating' => 4.4,
                'reviews' => 26,
                'category' => 'Fashion',
                'status' => 'Tersedia',
                'stock' => 20
            ],
            [
                'id' => 11,
                'name' => 'Kotak Penyimpanan Organizer',
                'description' => 'Kotak penyimpanan multifungsi dari karton dan plastik bekas',
                'price' => 65000,
                'image' => 'https://images.unsplash.com/photo-1590080876099-cd19e51a4f5d?w=500&h=500&fit=crop',
                'bank_sampah' => 'Bank Sampah Sadar',
                'bank_sampah_id' => 11,
                'rating' => 4.5,
                'reviews' => 31,
                'category' => 'Home',
                'status' => 'Tersedia',
                'stock' => 19
            ],
            [
                'id' => 12,
                'name' => 'Tas Laptop Stylish',
                'description' => 'Tas laptop premium dengan desain modern dari bahan daur ulang',
                'price' => 215000,
                'image' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=500&h=500&fit=crop',
                'bank_sampah' => 'Bank Sampah Induk Surabaya',
                'bank_sampah_id' => 1,
                'rating' => 4.8,
                'reviews' => 54,
                'category' => 'Accessories',
                'status' => 'Tersedia',
                'stock' => 9
            ]
        ];

        $catalogProducts = MarketplaceProduct::with('bankSampah')
            ->where('status', 'Tersedia')
            ->latest()
            ->get()
            ->map(fn (MarketplaceProduct $product): array => [
                'id' => $product->id,
                'source' => 'catalog',
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
                'rating' => 0,
                'reviews' => 0,
                'category' => $product->category ?? 'Lainnya',
                'status' => $product->status,
                'stock' => $product->stock,
            ])
            ->all();

        $products = array_merge($catalogProducts, $products);

        return view('dashboard.marketplace', ['products' => $products]);
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

        DB::transaction(function () use ($product, $validated, $request): void {
            $lockedProduct = MarketplaceProduct::whereKey($product->id)->lockForUpdate()->firstOrFail();

            if ($lockedProduct->status !== 'Tersedia' || $validated['quantity'] > $lockedProduct->stock) {
                abort(422, 'Stok produk tidak mencukupi.');
            }

            MarketplaceOrder::create([
                'user_id' => $request->user()->id,
                'marketplace_product_id' => $lockedProduct->id,
                'customer_name' => $validated['customer_name'],
                'customer_phone' => $validated['customer_phone'],
                'shipping_address' => $validated['shipping_address'],
                'quantity' => $validated['quantity'],
                'unit_price' => $lockedProduct->price,
                'total_price' => $lockedProduct->price * $validated['quantity'],
                'status' => 'Menunggu konfirmasi',
            ]);

            $lockedProduct->decrement('stock', $validated['quantity']);
        });

        return redirect()
            ->route('marketplace.product', $product)
            ->with('success', 'Pesanan berhasil dibuat. Bank sampah akan menghubungi Anda untuk konfirmasi.');
    }
}
