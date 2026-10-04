<?php

namespace Tests\Feature;

use App\Models\BankSampah;
use App\Models\MarketplaceOrder;
use App\Models\MarketplaceProduct;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MarketplaceOrdersTest extends TestCase
{
    use RefreshDatabase;

    public function test_marketplace_has_a_link_to_the_current_users_orders(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('marketplace'))
            ->assertOk()
            ->assertSee(route('marketplace.orders'))
            ->assertSee('Pesanan Saya');
    }

    public function test_user_sees_only_their_own_marketplace_orders_and_statuses(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $bank = BankSampah::create([
            'name' => 'Bank Sampah Uji',
            'address' => 'Alamat Bank Sampah Uji',
            'latitude' => -7.25,
            'longitude' => 112.75,
        ]);
        $product = MarketplaceProduct::create([
            'bank_sampah_id' => $bank->id,
            'name' => 'Tas Daur Ulang',
            'price' => 50000,
            'stock' => 10,
            'status' => 'Tersedia',
        ]);

        MarketplaceOrder::create([
            'user_id' => $user->id,
            'marketplace_product_id' => $product->id,
            'customer_name' => $user->name,
            'customer_phone' => '081234567890',
            'shipping_address' => 'Alamat Pengiriman Pengguna Pertama',
            'quantity' => 2,
            'unit_price' => 50000,
            'total_price' => 100000,
            'status' => 'Menunggu verifikasi pembayaran',
        ]);
        MarketplaceOrder::create([
            'user_id' => $otherUser->id,
            'marketplace_product_id' => $product->id,
            'customer_name' => $otherUser->name,
            'customer_phone' => '081234567891',
            'shipping_address' => 'Alamat Pengguna Lain',
            'quantity' => 1,
            'unit_price' => 50000,
            'total_price' => 50000,
            'status' => 'Pembayaran dikonfirmasi',
        ]);

        $this->actingAs($user)
            ->get(route('marketplace.orders'))
            ->assertOk()
            ->assertSee('Tas Daur Ulang')
            ->assertSee('Menunggu verifikasi pembayaran')
            ->assertSee('Rp 100.000')
            ->assertDontSee('Pembayaran dikonfirmasi')
            ->assertDontSee('Alamat Pengguna Lain');
    }

    public function test_marketplace_order_list_requires_authentication(): void
    {
        $this->get(route('marketplace.orders'))
            ->assertRedirect(route('login'));
    }

    public function test_payment_page_shows_confirmation_instead_of_upload_form_after_proof_is_sent(): void
    {
        $user = User::factory()->create();
        $bank = BankSampah::create([
            'name' => 'Bank Sampah Uji',
            'address' => 'Alamat Bank Sampah Uji',
            'latitude' => -7.25,
            'longitude' => 112.75,
        ]);
        $product = MarketplaceProduct::create([
            'bank_sampah_id' => $bank->id,
            'name' => 'Tas Daur Ulang',
            'price' => 50000,
            'stock' => 10,
            'status' => 'Tersedia',
        ]);
        $order = MarketplaceOrder::create([
            'user_id' => $user->id,
            'marketplace_product_id' => $product->id,
            'customer_name' => $user->name,
            'customer_phone' => '081234567890',
            'shipping_address' => 'Alamat Pengiriman Pengguna',
            'quantity' => 1,
            'unit_price' => 50000,
            'total_price' => 50000,
            'payment_proof' => 'payment-proofs/proof.jpg',
            'status' => 'Menunggu verifikasi pembayaran',
        ]);

        $this->actingAs($user)
            ->get(route('marketplace.payment', $order))
            ->assertOk()
            ->assertSee('Pembayaran Anda telah terkirim')
            ->assertSee('Silakan tunggu konfirmasi dari bank sampah.')
            ->assertSee('Lihat Status Pesanan')
            ->assertDontSee('Konfirmasi Pembayaran')
            ->assertDontSee('QRIS Pembayaran')
            ->assertDontSee('Ringkasan Pesanan')
            ->assertDontSee(route('marketplace.payment.upload', $order))
            ->assertDontSee('Kirim Bukti Pembayaran');
    }

    public function test_order_cannot_be_submitted_without_payment_proof(): void
    {
        $user = User::factory()->create();
        $bank = BankSampah::create([
            'name' => 'Bank Sampah Uji',
            'address' => 'Alamat Bank Sampah Uji',
            'latitude' => -7.25,
            'longitude' => 112.75,
        ]);
        $product = MarketplaceProduct::create([
            'bank_sampah_id' => $bank->id,
            'name' => 'Tas Daur Ulang',
            'price' => 50000,
            'stock' => 10,
            'status' => 'Tersedia',
        ]);

        $this->actingAs($user)
            ->from(route('marketplace.product', $product))
            ->post(route('marketplace.product.buy', $product), [
                'customer_name' => $user->name,
                'customer_phone' => '081234567890',
                'shipping_address' => 'Alamat Pengiriman Pengguna',
                'quantity' => 1,
            ])
            ->assertRedirect(route('marketplace.product', $product))
            ->assertSessionHasErrors('payment_proof');

        $this->assertDatabaseCount('marketplace_orders', 0);
        $this->assertSame(10, $product->fresh()->stock);
    }

    public function test_order_is_created_with_payment_proof_in_one_submission(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $bank = BankSampah::create([
            'name' => 'Bank Sampah Uji',
            'address' => 'Alamat Bank Sampah Uji',
            'latitude' => -7.25,
            'longitude' => 112.75,
        ]);
        $product = MarketplaceProduct::create([
            'bank_sampah_id' => $bank->id,
            'name' => 'Tas Daur Ulang',
            'price' => 50000,
            'stock' => 10,
            'status' => 'Tersedia',
        ]);

        $this->actingAs($user)
            ->post(route('marketplace.product.buy', $product), [
                'customer_name' => $user->name,
                'customer_phone' => '081234567890',
                'shipping_address' => 'Alamat Pengiriman Pengguna',
                'quantity' => 2,
                'payment_proof' => UploadedFile::fake()->createWithContent(
                    'payment-proof.png',
                    base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+aW+cAAAAASUVORK5CYII=')
                ),
            ])
            ->assertRedirect();

        $order = MarketplaceOrder::firstOrFail();
        $this->assertSame('Menunggu verifikasi pembayaran', $order->status);
        $this->assertNotNull($order->payment_proof);
        Storage::disk('public')->assertExists($order->payment_proof);
        $this->assertSame(8, $product->fresh()->stock);
    }
}
