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
     * A basic feature test example.
     *
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
}
