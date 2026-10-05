<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_form_shows_current_user_data(): void
    {
        $user = User::factory()->create([
            'name' => 'Current Name',
            'email' => 'current@example.com',
        ]);

        $this->actingAs($user)
            ->get(route('profile'))
            ->assertOk()
            ->assertSee('value="Current Name"', false)
            ->assertSee('value="current@example.com"', false)
            ->assertSee(route('profile.update'), false);
    }

    public function test_user_can_update_profile_and_password(): void
    {
        $user = User::factory()->create([
            'password' => 'old-password',
        ]);

        $this->actingAs($user)
            ->put(route('profile.update'), [
                'name' => 'Updated Name',
                'email' => 'updated@example.com',
                'password' => 'new-password',
                'password_confirmation' => 'new-password',
            ])
            ->assertRedirect(route('profile'))
            ->assertSessionHas('success');

        $user->refresh();

        $this->assertSame('Updated Name', $user->name);
        $this->assertSame('updated@example.com', $user->email);
        $this->assertTrue(Hash::check('new-password', $user->password));
    }

    public function test_blank_password_keeps_current_password_and_unchanged_email_is_allowed(): void
    {
        $user = User::factory()->create([
            'name' => 'Current Name',
            'email' => 'current@example.com',
            'password' => 'old-password',
        ]);

        $this->actingAs($user)
            ->put(route('profile.update'), [
                'name' => 'Updated Name',
                'email' => 'current@example.com',
                'password' => '',
                'password_confirmation' => '',
            ])
            ->assertRedirect(route('profile'))
            ->assertSessionHas('success');

        $user->refresh();

        $this->assertSame('Updated Name', $user->name);
        $this->assertTrue(Hash::check('old-password', $user->password));
    }
}
