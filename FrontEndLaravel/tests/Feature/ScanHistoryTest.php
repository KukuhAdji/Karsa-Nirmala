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
        $response->assertSee('organik');
        $response->assertDontSee('e-waste');
    }
}
