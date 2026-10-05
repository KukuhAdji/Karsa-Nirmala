<?php

namespace Tests\Feature;

use App\Models\Classification;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ScanHistoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_history_only_shows_current_users_scans(): void
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();

        Classification::create([
            'user_id' => $userA->id,
            'image' => 'scans/user-a.jpg',
            'category' => 'organik',
            'confidence' => 96.5,
            'recommendation' => 'Keep it up',
        ]);

        Classification::create([
            'user_id' => $userB->id,
            'image' => 'scans/user-b.jpg',
            'category' => 'e-waste',
            'confidence' => 99.1,
            'recommendation' => 'Recycle it',
        ]);

        $response = $this->actingAs($userA)->get(route('scanner.history'));

        $response->assertOk();
        $response->assertSee('Organik');
        $response->assertDontSee('E-waste');
    }

    public function test_user_can_view_their_saved_scan_details(): void
    {
        $user = User::factory()->create();
        $classification = Classification::create([
            'user_id' => $user->id,
            'image' => 'scans/bottle.jpg',
            'category' => 'anorganik',
            'confidence' => 81.4,
            'recommendation' => 'Botol dapat didaur ulang.',
        ]);

        $response = $this->actingAs($user)
            ->get(route('scanner.history.detail', $classification));

        $response->assertOk();
        $response->assertSee('Detail Hasil Scan');
        $response->assertSee('anorganik');
        $response->assertSee('81% keyakinan');
        $response->assertSee('Botol dapat didaur ulang.');
        $response->assertSee('Kembali ke Riwayat Scan');
    }

    public function test_user_cannot_view_another_users_scan_details(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $classification = Classification::create([
            'user_id' => $owner->id,
            'image' => 'scans/private.jpg',
            'category' => 'organik',
            'confidence' => 70,
            'recommendation' => 'Private scan',
        ]);

        $this->actingAs($otherUser)
            ->get(route('scanner.history.detail', $classification))
            ->assertNotFound();
    }
}
