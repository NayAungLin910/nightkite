<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class NotAuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Login page is
     * accessible before login
     * @return void
     */
    public function test_login_page_visit_before_login(): void
    {
        $response = $this->get(route('admin.login'));

        $response->assertStatus(200);
    }

    /**
     * Register page is accessible
     * before auth
     */
    public function test_register_page_visit_before_login(): void
    {
        $response = $this->get(route('admin.register'));

        $response->assertStatus(200);
    }

    /**
     * Main page is accessible
     * before login
     * @return void
     */
    public function test_main_page_visit_before_login(): void
    {
        $response = $this->get(route('welcome'));

        $response->assertStatus(200);
    }

    /**
     * Admin profile page in dashboard is
     * inaccessible before login
     * @return void
     */
    public function test_admin_dashboard_visit_before_login(): void
    {
        $response = $this->get(route('admin.dashboard.profile'));

        $response->assertStatus(302);
    }

    /**
     * Logout post request is rejecteed if
     * not logined yet
     * @return void
     */
    public function test_logout_post_before_login(): void
    {
        $response = $this->post(route('admin.dashboard.logout'));

        $response->assertStatus(302);
    }

    /**
     * Article search is available even though
     * not logined yet
     * @return void
     */
    public function test_article_search_global_visit(): void
    {
        $response = $this->get(route('article.search'));

        $response->assertStatus(200);
    }

    /**
     * Test the api get request call to see tags
     * returns 200 status code when not logined.
     * @return void
     */
    public function test_search_tags_get_api(): void
    {
        $response = $this->get(route('api.tags'));

        $response->assertStatus(200);
    }

    /**
     * Aseerts that the tags are searchable through
     * post api request even when not logined
     * @return void
     */
    public function test_search_tags_post_api(): void
    {
        $response = $this->post(route('api.tags'), ['search' => 'abc']);

        $response->assertStatus(200);
    }

    /**
     * Rgister an account on register page
     * when not logined yet
     * @return void
     */
    public function test_register_and_admin_account_post_(): void
    {
        Storage::fake('test');

        $file = UploadedFile::fake()->image('avatar.jpg')->size(100);

        $response = $this->post(route('admin.register'), [
            "name" => "Test User",
            "email" => "testuser@gmail.com",
            "description" => "Just a test uesr!",
            "password" => 'password123*A',
            "password_confirmation" => 'password123*A',
            "image" => $file,
        ]);

        $response->assertRedirect(route('welcome'))->assertStatus(302);

        $this->assertDatabaseHas('users', [
            'email' => 'testuser@gmail.com'
        ]);
    }

    /**
     * User can login after the account has
     * been accepted to be an admin by the superadmin
     * @return void
     */
    public function test_login_as_an_admin_after_account_accepted(): void
    {

        $user = User::create([
            "name" => "Test User",
            "email" => "testuser@gmail.com",
            "description" => "Just a test uesr!",
            "password" => Hash::make('password123*A'),
            "image" => '/default_images/nightkite_logo_transparent.webp',
            'role' => 2,
        ]);

        $response = $this->post(route('admin.login'), [
            'email' => 'testuser@gmail.com',
            'password' => 'password123*A',
        ]);

        $response->assertRedirect(route('admin.dashboard.profile'))->assertStatus(302);
        $this->assertAuthenticated();
    }
}
