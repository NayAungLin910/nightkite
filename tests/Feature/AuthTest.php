<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the profile page is accessible
     * when authenticated
     * 
     * @return void
     */
    public function test_profile_access(): void
    {
        $user = User::factory()->accepted()->create();

        $response = $this->actingAs($user)
            ->get(route('admin.dashboard.profile'));

        $response->assertStatus(200);
    }

    /**
     * Test the profile update page is accessible
     * when authenticated
     * 
     * @return void
     */
    public function test_profile_update_page(): void
    {
        $user = User::factory()->accepted()->create();

        $response = $this->actingAs($user)
            ->get(route('admin.dashboard.update-profile'));

        $response->assertStatus(200);
    }

    /**
     * Test the profile update post request
     * is doable when authenticated
     * 
     * @return void
     */
    public function test_profile_update_post_request(): void
    {
        $tempPassword = 'password123*A';
        $tempName = 'Test User';

        $user = User::factory()
            ->state(['password' => Hash::make($tempPassword)])
            ->accepted()
            ->create();

        $file = UploadedFile::fake()->image('avatar.jpg')->size(100);

        $response = $this->actingAs($user)
            ->post(route('admin.dashboard.update-profile'), [
                "name" => $tempName,
                "email" => $user->email,
                "description" => $user->description,
                "password" => $tempPassword,
                "image" => $file,
            ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('users', [
            'name' => $tempName,
        ]);
    }

    /**
     * Test the change passsword page is accessible
     * when authenticated
     * 
     * @return void
     */
    public function test_change_password_page(): void
    {
        $user = User::factory()->accepted()->create();

        $response = $this->actingAs($user)
            ->get(route('admin.dashboard.change-password'));

        $response->assertStatus(200);
    }

    /**
     * Test the change passsword post request 
     * is doable when authenticated
     * 
     * @return void
     */
    public function test_change_password_post_request(): void
    {
        $tempPassword = 'password123*A';
        $tempNewPassword = 'password321*A';

        $user = User::factory()
            ->state(['password' => Hash::make($tempPassword)])
            ->accepted()
            ->create();

        $response = $this->actingAs($user)
            ->post(route('admin.dashboard.change-password'), [
                "new_password" => $tempNewPassword,
                "new_password_confirmation" => $tempNewPassword,
                "password" => $tempPassword,
            ]);

        $response->assertStatus(302);

        $response->assertRedirect(route('admin.dashboard.profile'));
    }

    /**
     * Test the search admin account page is accessible
     * when authenticated
     * 
     * @return void
     */
    public function test_search_admin_page(): void
    {
        $user = User::factory()->accepted()->create();

        $user2 = User::factory()->state(['name' => 'Temp User'])->accepted()->create();

        $response = $this->actingAs($user)
            ->get(route('admin.dashboard.search-account', ['search' => $user2->name]));

        $response->assertStatus(200);

        $response->assertSee($user2->name, true);
    }
}
