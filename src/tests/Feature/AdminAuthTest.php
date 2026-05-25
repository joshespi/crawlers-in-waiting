<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_loads(): void
    {
        $this->get('/login')->assertStatus(200);
    }

    public function test_admin_redirects_unauthenticated_to_login(): void
    {
        $this->get('/admin')->assertRedirect('/login');
    }

    public function test_valid_credentials_redirect_to_admin(): void
    {
        $user = User::factory()->create(['password' => Hash::make('secret')]);

        $this->post('/login', ['email' => $user->email, 'password' => 'secret'])
            ->assertRedirect(route('admin.episodes.index'));
    }

    public function test_invalid_credentials_return_error(): void
    {
        User::factory()->create(['password' => Hash::make('correct')]);

        $this->post('/login', ['email' => 'wrong@example.com', 'password' => 'wrong'])
            ->assertSessionHasErrors('email');
    }

    public function test_logout_redirects_home(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user)
            ->post('/logout')
            ->assertRedirect('/');
    }
}
