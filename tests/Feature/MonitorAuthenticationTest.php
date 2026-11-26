<?php

namespace Tests\Feature;

use App\Models\User;
use App\Notifications\MonitorResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class MonitorAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    private const PASSWORD = 'MonitorTesting2026!';

    public function test_private_monitor_requires_a_session_and_does_not_accept_basic_auth(): void
    {
        $this->get('/monitor/gocontact')->assertRedirect('/monitor/login');
        $this->withHeader('Authorization', 'Basic '.base64_encode('monitor:old-password'))
            ->get('/monitor/gocontact')->assertRedirect('/monitor/login');
        $this->getJson('/monitor/gocontact')->assertUnauthorized();
    }

    public function test_authentication_pages_are_private_and_registration_is_disabled(): void
    {
        foreach (['/monitor/login', '/monitor/forgot-password', '/monitor/reset-password/example-token?email=test@example.com'] as $path) {
            $this->get($path)->assertOk()->assertHeader('X-Robots-Tag', 'noindex, nofollow')
                ->assertHeader('Referrer-Policy', 'no-referrer')->assertSee('Ofertas Tienda');
        }
        $this->assertFalse(Route::has('register'));
        $this->get('/monitor/register')->assertNotFound();
        $this->post('/monitor/register', ['email' => 'test@example.com'])->assertStatus(405);
    }

    public function test_authorized_account_can_login_and_logout_with_session_regeneration(): void
    {
        $user = $this->user();
        $this->get('/monitor/login')->assertOk();
        $before = session()->getId();
        $this->post('/monitor/login', ['email' => strtoupper($user->email), 'password' => self::PASSWORD])
            ->assertRedirect('/monitor/gocontact');
        $this->assertAuthenticatedAs($user);
        $this->assertNotSame($before, session()->getId());
        $this->get('/monitor/gocontact')->assertOk()->assertSee('Monitoreo de leads');
        $this->get('/monitor/login')->assertRedirect('/monitor/gocontact');
        $this->post('/monitor/logout')->assertRedirect('/monitor/login');
        $this->assertGuest();
        $this->get('/monitor/gocontact')->assertRedirect('/monitor/login');
    }

    public function test_existing_user_without_permission_cannot_login_or_read_the_monitor(): void
    {
        $user = $this->user(false);
        $this->post('/monitor/login', ['email' => $user->email, 'password' => self::PASSWORD])
            ->assertSessionHasErrors('email');
        $this->assertGuest();
        $this->actingAs($user)->get('/monitor/gocontact')->assertForbidden()->assertSee('Tu cuenta no tiene acceso');
        $this->get('/monitor/account')->assertForbidden();
    }

    public function test_failed_attempts_are_throttled_using_database_even_when_default_cache_is_array(): void
    {
        config(['cache.default' => 'array', 'monitor.cache_store' => 'database']);
        $user = $this->user();
        for ($i = 0; $i < 5; $i++) {
            $this->post('/monitor/login', ['email' => $user->email, 'password' => 'incorrect'])->assertSessionHasErrors('email');
        }
        // A fresh middleware/limiter instance is constructed on each request.
        $this->post('/monitor/login', ['email' => $user->email, 'password' => self::PASSWORD])
            ->assertStatus(429)->assertHeader('Retry-After')->assertSee('Hagamos una breve pausa');
        $this->assertGreaterThan(0, DB::table('cache')->count());
        $this->assertGuest();
        $this->travel(61)->seconds();
        $this->post('/monitor/login', ['email' => $user->email, 'password' => self::PASSWORD])->assertRedirect('/monitor/gocontact');
    }

    public function test_recovery_is_explicitly_unavailable_until_mail_delivery_is_configured(): void
    {
        Notification::fake();
        config(['monitor.password_reset_email_enabled' => false]);
        $user = $this->user();
        $this->get('/monitor/forgot-password')->assertOk()->assertSee('La recuperación por correo aún no está disponible.')->assertDontSee('name="email"', false);
        $this->post('/monitor/forgot-password', ['email' => $user->email])->assertSessionHasErrors('email');
        Notification::assertNothingSent();
    }

    public function test_recovery_uses_the_same_response_for_enabled_disabled_and_unknown_accounts(): void
    {
        Notification::fake();
        config(['monitor.password_reset_email_enabled' => true]);
        $enabled = $this->user();
        $disabled = $this->user(false);
        $messages = [];
        foreach ([$enabled->email, $disabled->email, 'unknown@example.com'] as $email) {
            $response = $this->from('/monitor/forgot-password')->post('/monitor/forgot-password', ['email' => $email]);
            $response->assertRedirect('/monitor/forgot-password')->assertSessionHasNoErrors();
            $messages[] = session('status');
        }
        $this->assertCount(1, array_unique($messages));
        Notification::assertSentTo($enabled, MonitorResetPassword::class);
        Notification::assertNotSentTo($disabled, MonitorResetPassword::class);
        $this->assertSame(1, DB::table('password_resets')->count());
    }

    public function test_reset_link_uses_the_configured_origin_and_a_working_spanish_template(): void
    {
        $user = $this->user();
        config(['monitor.public_url' => 'https://ofertastienda.co']);
        $message = (new MonitorResetPassword('test-token'))->toMail($user);
        $this->assertStringStartsWith('https://ofertastienda.co/monitor/reset-password/test-token', $message->viewData['url']);
        $this->assertStringContainsString(urlencode($user->email), $message->viewData['url']);
        $this->assertStringContainsString('Recupera tu acceso', view($message->view, $message->viewData)->render());
    }

    public function test_valid_token_changes_password_only_once_and_rotates_remember_token(): void
    {
        $user = $this->user();
        $oldRemember = $user->remember_token;
        $token = Password::broker('users')->createToken($user);
        $data = ['email' => $user->email, 'token' => $token, 'password' => 'NewSecurePassword2026!', 'password_confirmation' => 'NewSecurePassword2026!'];
        $this->from('/monitor/reset-password/'.$token)->post('/monitor/reset-password', $data)->assertRedirect('/monitor/login')->assertSessionHasNoErrors();
        $this->assertTrue(Hash::check($data['password'], $user->fresh()->password));
        $this->assertNotSame($oldRemember, $user->fresh()->remember_token);
        $this->assertDatabaseCount('password_resets', 0);
        $this->post('/monitor/reset-password', $data)->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_expired_token_or_revoked_permission_does_not_change_the_password(): void
    {
        $user = $this->user();
        $token = Password::broker('users')->createToken($user);
        $data = ['email' => $user->email, 'token' => $token, 'password' => 'NewSecurePassword2026!', 'password_confirmation' => 'NewSecurePassword2026!'];
        $user->forceFill(['monitor_access' => false])->save();
        $this->post('/monitor/reset-password', $data)->assertSessionHasErrors('email');
        $user->forceFill(['monitor_access' => true])->save();
        $this->travel(61)->minutes();
        $this->post('/monitor/reset-password', $data)->assertSessionHasErrors('email');
        $this->assertTrue(Hash::check(self::PASSWORD, $user->fresh()->password));
    }

    public function test_password_update_requires_current_password_and_confirmation(): void
    {
        $user = $this->user();
        $this->actingAs($user)->get('/monitor/account')->assertOk()->assertSee($user->email);
        $data = ['current_password' => 'incorrect', 'password' => 'UpdatedPassword2026!', 'password_confirmation' => 'UpdatedPassword2026!'];
        $this->put('/monitor/password', $data)->assertSessionHasErrorsIn('updatePassword', 'current_password');
        $this->put('/monitor/password', array_replace($data, ['current_password' => self::PASSWORD]))->assertSessionHas('status', 'password-updated');
        $this->assertTrue(Hash::check($data['password'], $user->fresh()->password));
        $this->get('/monitor/gocontact')->assertOk();
    }

    public function test_revoking_permission_blocks_an_existing_session(): void
    {
        $user = $this->user();
        $this->post('/monitor/login', ['email' => $user->email, 'password' => self::PASSWORD])->assertRedirect('/monitor/gocontact');
        $this->artisan('monitor:user '.$user->email.' --revoke')->assertSuccessful();
        \Illuminate\Support\Facades\Auth::forgetGuards();
        $this->get('/monitor/gocontact')->assertForbidden();
    }

    public function test_password_change_invalidates_a_preexisting_session_before_its_first_monitor_visit(): void
    {
        $user = $this->user();
        $this->post('/monitor/login', ['email' => $user->email, 'password' => self::PASSWORD])->assertRedirect('/monitor/gocontact');
        $this->assertSame($user->password, session('password_hash_web'));
        $user->forceFill(['password' => 'ChangedByOtherSession2026!'])->save();
        \Illuminate\Support\Facades\Auth::forgetGuards();
        $this->get('/monitor/gocontact')->assertRedirect('/monitor/login');
        $this->assertGuest();
    }

    public function test_mail_transport_errors_do_not_expose_credentials_or_account_existence(): void
    {
        config(['monitor.password_reset_email_enabled' => true]);
        Password::shouldReceive('broker')->once()->with('users')->andReturnSelf();
        Password::shouldReceive('sendResetLink')->once()->andThrow(new \Symfony\Component\Mailer\Exception\TransportException('private-smtp-details'));
        $this->from('/monitor/forgot-password')->post('/monitor/forgot-password', ['email' => 'test@example.com'])
            ->assertRedirect('/monitor/forgot-password')->assertSessionHasNoErrors()->assertSessionHas('status');
        $this->assertStringNotContainsString('private-smtp-details', session('status'));
    }

    public function test_monitor_forms_enforce_csrf_outside_the_test_environment(): void
    {
        config(['app.env' => 'local']);
        $this->app->instance('env', 'local');
        $this->post('/monitor/login', ['email' => 'test@example.com', 'password' => self::PASSWORD])->assertStatus(419)->assertSee('Tu sesión ha caducado');
    }

    public function test_admin_command_creates_and_revokes_an_individual_account(): void
    {
        $this->artisan('monitor:user operator@example.com --name=Operador')
            ->expectsQuestion('Contraseña (mínimo 12 caracteres, con letras y números)', self::PASSWORD)
            ->expectsQuestion('Repite la contraseña', self::PASSWORD)->assertSuccessful();
        $user = User::where('email', 'operator@example.com')->firstOrFail();
        $this->assertTrue($user->monitor_access);
        $this->assertTrue(Hash::check(self::PASSWORD, $user->password));
        $this->artisan('monitor:user operator@example.com --revoke')->assertSuccessful();
        $this->assertFalse($user->fresh()->monitor_access);
    }

    private function user(bool $access = true): User
    {
        return User::factory()->create(['password' => self::PASSWORD, 'monitor_access' => $access]);
    }

    public function test_noninteractive_provisioning_reads_a_password_file(): void
    {
        $path = tempnam('/tmp', 'monitor-password-test-');
        file_put_contents($path, self::PASSWORD."\n");
        chmod($path, 0600);
        try {
            $this->artisan('monitor:user', ['email' => 'operator@example.com', '--name' => 'Operador', '--password-file' => $path])->assertSuccessful();
            $this->assertTrue(Hash::check(self::PASSWORD, User::where('email', 'operator@example.com')->firstOrFail()->password));
        } finally {
            unlink($path);
        }
    }

    public function test_passwords_that_bcrypt_cannot_safely_hash_are_rejected_without_changing_the_account(): void
    {
        $user = $this->user();
        $token = Password::broker('users')->createToken($user);
        foreach ([str_repeat('a', 73).'1', str_repeat('é', 40).'1', 'ValidPassword2026'."\0"] as $password) {
            $this->post('/monitor/reset-password', ['email' => $user->email, 'token' => $token, 'password' => $password, 'password_confirmation' => $password])->assertSessionHasErrors('password');
            $this->assertTrue(Hash::check(self::PASSWORD, $user->fresh()->password));
        }
    }
}
