<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SuperAuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test accept account page is visitable 
     * when the user is super admin 
     * @return void
     */
    public function test_superauth_accept_accounts_get_page()
    {
        $user = User::factory()->superAdmin()->create();

        $unacceptedUser = User::factory()->create();

        $response = $this->actingAs($user)->get(
            route('admin.dashboard.accept-accounts', [
                'search' => $unacceptedUser->name
            ])
        );

        $response->assertStatus(200);

        $response->assertSee($unacceptedUser->name, true);
    }

    /**
     * Test the admin account accept page is not
     * visitable when the user is not super admin
     * but just an admin
     * @return void
     */
    public function test_normal_admin_accept_accounts_get_page()
    {
        $user = User::factory()->accepted()->create();

        $unacceptedUser = User::factory()->create();

        $response = $this->actingAs($user)->get(
            route('admin.dashboard.accept-accounts', [
                'search' => $unacceptedUser->name
            ])
        );

        $response->assertStatus(302);

        $response->assertRedirect(route('welcome'));
    }

    /**
     * Test the super admin can accept admin
     * accounts to be loginable and used
     *
     * @return void
     */
    public function test_superauth_accept_accounts_post_request()
    {
        $user = User::factory()->superAdmin()->create();

        $unacceptedUser = User::factory()->create();

        $unacceptedUser = User::factory()->create();

        $response = $this->actingAs($user)->post(
            route('admin.dashboard.accept-accounts'),
            [
                "email" => $unacceptedUser->email
            ]
        );

        $response->assertStatus(302);

        $this->assertDatabaseHas('users', [
            'email' => $unacceptedUser->email,
            'role' => '2'
        ]);
    }

    /**
     * Test the super admin can accept admin
     * accounts to be loginable and used
     *
     * @return void
     */
    public function test_superauth_decline_accounts_post_request()
    {
        $user = User::factory()->superAdmin()->create();

        $unacceptedUser = User::factory()->create();

        $unacceptedUser = User::factory()->create();

        $response = $this->actingAs($user)->post(
            route('admin.dashboard.decline-account'),
            [
                "email" => $unacceptedUser->email
            ]
        );

        $response->assertStatus(302);

        $this->assertDatabaseMissing('users', [
            'email' => $unacceptedUser->email,
        ]);
    }

    /**
     * Test the super admin can accept admin
     * accounts to be loginable and used
     *
     * @return void
     */
    public function test_superauth_delete_admin_post_request()
    {
        $user = User::factory()->superAdmin()->create();

        $unacceptedUser = User::factory()->accepted()->create();

        $response = $this->actingAs($user)->post(
            route('admin.dashboard.delete-admin-account'),
            [
                "email" => $unacceptedUser->email
            ]
        );

        $response->assertStatus(302);

        $this->assertDatabaseMissing('users', [
            'email' => $unacceptedUser->email,
        ]);
    }
}
