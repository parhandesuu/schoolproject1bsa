<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use DatabaseTransactions;

    public function test_profile_page_is_displayed(): void
    {
        $user = User::factory()->create(['role' => 'admin']);

        $response = $this
            ->actingAs($user)
            ->get(route('admin.profile.edit'));

        $response->assertOk();
    }

    public function test_profile_information_can_be_updated(): void
    {
        $user = User::factory()->create(['role' => 'admin']);

        $response = $this
            ->actingAs($user)
            ->patch(route('admin.profile.update'), [
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('admin.profile.edit'));

        $user->refresh();

        $this->assertSame('Test User', $user->name);
        $this->assertSame('test@example.com', $user->email);
    }

    public function test_profile_password_can_be_updated(): void
    {
        $user = User::factory()->create([
            'role' => 'admin',
            'password' => Hash::make('old-password-123'),
        ]);

        $response = $this
            ->actingAs($user)
            ->patch(route('admin.profile.password'), [
                'current_password' => 'old-password-123',
                'new_password' => 'new-password-123',
                'new_password_confirmation' => 'new-password-123',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('admin.profile.edit'));

        $user->refresh();
        $this->assertTrue(Hash::check('new-password-123', $user->password));
    }
}
