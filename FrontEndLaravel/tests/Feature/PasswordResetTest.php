<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\ResetPassword;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_request_a_password_reset_and_set_a_new_password(): void
    {
        Notification::fake();
        $user = User::factory()->create();
        $token = null;

        $this->post(route('password.email'), ['email' => $user->email])
            ->assertRedirect()
            ->assertSessionHas('resetStatus');

        $this->get(route('login'))
            ->assertOk()
            ->assertSee('Send Reset Link')
            ->assertSee(route('password.email'));

        Notification::assertSentTo(
            $user,
            ResetPassword::class,
            function (ResetPassword $notification) use (&$token): bool {
                $token = $notification->token;

                return true;
            }
        );

        $this->get(route('password.reset', ['token' => $token, 'email' => $user->email]))
            ->assertOk()
            ->assertSee('Choose a new password');

        $this->post(route('password.update'), [
            'token' => $token,
            'email' => $user->email,
            'password' => 'new-secure-password',
            'password_confirmation' => 'new-secure-password',
        ])
            ->assertRedirect(route('login'))
            ->assertSessionHas('success');

        $this->assertTrue(Hash::check('new-secure-password', $user->fresh()->password));
        $this->assertDatabaseMissing('password_reset_tokens', ['email' => $user->email]);
    }

    public function test_localhost_can_open_password_reset_form_without_sending_email(): void
    {
        Notification::fake();
        $this->app['env'] = 'local';
        $user = User::factory()->create();

        $this->withServerVariables([
            'HTTP_HOST' => 'localhost:8000',
            'REMOTE_ADDR' => '127.0.0.1',
        ])->withSession(['_token' => 'local-reset-test-token'])
            ->withHeader('X-CSRF-TOKEN', 'local-reset-test-token')
            ->post(route('password.email'), ['email' => $user->email])
            ->assertRedirect(route('password.local-reset.form'))
            ->assertSessionHas('local_password_reset_email', $user->email);

        $this->get(route('password.local-reset.form'))
            ->assertOk()
            ->assertSee('Resetting the password for '.$user->email);

        Notification::assertNothingSent();

        $this->post(route('password.local-reset.update'), [
            'password' => 'new-local-password',
            'password_confirmation' => 'new-local-password',
        ])
            ->assertRedirect(route('login'))
            ->assertSessionHas('success')
            ->assertSessionMissing('local_password_reset_email');

        $this->assertTrue(Hash::check('new-local-password', $user->fresh()->password));
    }

    public function test_password_reset_bypass_is_not_available_outside_local_environment(): void
    {
        $this->app['env'] = 'production';

        $this->withServerVariables([
            'HTTP_HOST' => 'localhost:8000',
            'REMOTE_ADDR' => '127.0.0.1',
        ])->get(route('password.local-reset.form'))
            ->assertNotFound();
    }
}
