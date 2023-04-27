<?php

namespace Tests\Feature;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class TagTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Test the create tag page is accessible
     * when authenticated
     * 
     * @return void
     */
    public function test_create_tag_page(): void
    {
        $user = User::factory()->accepted()->create();

        $response = $this->actingAs($user)
            ->get(route('admin.dashboard.create-tags'));

        $response->assertStatus(200);
    }

    /**
     * Test the create tag post request is doable
     * when authenticated
     * 
     * @return void
     */
    public function test_create_tag_post(): void
    {
        $user = User::factory()->accepted()->create();

        $response = $this->actingAs($user)
            ->post(route('admin.dashboard.create-tags'), [
                "name" => "Sports Man"
            ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('tags', [
            'title' => 'Sports Man',
        ]);
    }

    /**
     * Test the get tag page is accessible
     * when authenticated
     * 
     * @return void
     */
    public function test_get_tag_page(): void
    {
        $user = User::factory()->accepted()->has(Tag::factory()->count(1), 'tags')->create();

        $tag = $user->tags->first();

        $response = $this->actingAs($user)
            ->get(route('admin.dashboard.get-tags', ['search' => $tag->title]));

        $response->assertStatus(200);

        $response->assertSee($tag->title, true);
    }

    /**
     * Test the update tag page is accessible
     * when authenticated
     * 
     * @return void
     */
    public function test_update_tag_page(): void
    {
        $user = User::factory()->accepted()->create();

        $tag = Tag::create([
            'title' => 'Health',
            'slug' =>  Str::slug(random_int(1000000000, 9999999999) . 'Health'),
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)
            ->get(route('admin.dashboard.update-tag', ["slug" => $tag->slug]));

        $response->assertStatus(200);
    }

    /**
     * Test that tag update post request is doable
     * when authenticated
     * 
     * @return void
     */
    public function test_update_post_tag(): void
    {
        $user = User::factory()->accepted()->create();

        $tag = Tag::create([
            'title' => 'Health',
            'slug' =>  Str::slug(random_int(1000000000, 9999999999) . 'Health'),
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)
            ->post(route('admin.dashboard.update-tag', ["slug" => $tag->slug]), [
                "name" => 'Health and Fitness'
            ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('tags', [
            'title' => 'Health and Fitness',
        ]);
    }

    /**
     * Test that tag update post request is doable
     * when authenticated
     * 
     * @return void
     */
    public function test_delete_tag_post(): void
    {
        $user = User::factory()->accepted()->create();

        $tag = Tag::create([
            'title' => 'Health',
            'slug' =>  Str::slug(random_int(1000000000, 9999999999) . 'Health'),
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)
            ->post(route('admin.dashboard.delete-tag'), [
                "slug" =>  $tag->slug
            ]);

        $response->assertStatus(302);

        $this->assertDatabaseMissing('tags', [
            'title' => 'Health',
        ]);
    }
}
