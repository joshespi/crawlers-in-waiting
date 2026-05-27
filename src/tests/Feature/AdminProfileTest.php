<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminProfileTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create([
            'name' => 'Original Name',
            'email' => 'original@example.com',
            'password' => Hash::make('password'),
        ]);
    }

    public function test_profile_page_requires_auth(): void
    {
        $this->get(route('admin.profile.edit'))->assertRedirect('/login');
    }

    public function test_profile_page_loads(): void
    {
        $this->actingAs($this->admin)
            ->get(route('admin.profile.edit'))
            ->assertStatus(200)
            ->assertSee('Original Name');
    }

    public function test_can_update_name_and_email(): void
    {
        $this->actingAs($this->admin)->put(route('admin.profile.update'), [
            'name'  => 'New Name',
            'email' => 'new@example.com',
        ])->assertRedirect(route('admin.profile.edit'));

        $this->assertDatabaseHas('users', ['name' => 'New Name', 'email' => 'new@example.com']);
    }

    public function test_can_change_password(): void
    {
        $this->actingAs($this->admin)->put(route('admin.profile.update'), [
            'name'                  => $this->admin->name,
            'email'                 => $this->admin->email,
            'password'              => 'newpassword1',
            'password_confirmation' => 'newpassword1',
        ])->assertRedirect(route('admin.profile.edit'));

        $this->assertTrue(Hash::check('newpassword1', $this->admin->fresh()->password));
    }

    public function test_password_unchanged_when_blank(): void
    {
        $original = $this->admin->password;

        $this->actingAs($this->admin)->put(route('admin.profile.update'), [
            'name'  => $this->admin->name,
            'email' => $this->admin->email,
        ])->assertRedirect(route('admin.profile.edit'));

        $this->assertSame($original, $this->admin->fresh()->password);
    }

    public function test_email_must_be_unique(): void
    {
        User::factory()->create(['email' => 'taken@example.com']);

        $this->actingAs($this->admin)->put(route('admin.profile.update'), [
            'name'  => $this->admin->name,
            'email' => 'taken@example.com',
        ])->assertSessionHasErrors('email');
    }

    public function test_password_confirmation_must_match(): void
    {
        $this->actingAs($this->admin)->put(route('admin.profile.update'), [
            'name'                  => $this->admin->name,
            'email'                 => $this->admin->email,
            'password'              => 'newpassword1',
            'password_confirmation' => 'different',
        ])->assertSessionHasErrors('password');
    }
}
