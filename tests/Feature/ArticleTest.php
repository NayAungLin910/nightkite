<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Support\Str;

class ArticleTest extends TestCase
{
    use RefreshDatabase;


    /**
     * Test the get tag page is accessible
     * when authenticated
     * 
     * @return void
     */
    public function test_get_articles_page(): void
    {
        $user = User::factory()->accepted()->has(Article::factory()->count(1))->create();

        $article = $user->articles->first();

        $response = $this->actingAs($user)
            ->get(route('admin.dashboard.search-article', ['search' => $article->title]));

        $response->assertStatus(200);

        $response->assertSee($article->title, true);
    }

    /**
     * Test the create article page is accessible
     * when authenticated
     * 
     * @return void
     */
    public function test_article_create_page_get(): void
    {
        $user = User::factory()->accepted()->create();

        $response = $this->actingAs($user)
            ->get(route('admin.dashboard.create-article'));

        $response->assertStatus(200);
    }

    /**
     * Test the create article post request is doable
     * when authenticated
     * 
     * @return void
     */
    public function test_create_article_post_request(): void
    {
        $user = User::factory()->accepted()->create();

        Storage::fake('test');

        $file = UploadedFile::fake()->image('avatar.jpg')->size(100);

        $tag = Tag::create([
            'title' => 'Health',
            'slug' =>  Str::slug(random_int(1000000000, 9999999999) . 'Health'),
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)
            ->post(route('admin.dashboard.create-article'), [
                "title" => "Temp Article",
                "meta_description" => "Just a temporary article.",
                "description" => "<p>Just some temporary article.</p>",
                "image" => $file,
                "tags" => [$tag->id],
            ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('articles', [
            'title' => 'Temp Article',
        ]);
    }

    /**
     * Test the update article ppage is
     * accessible when authenticated
     * @return void
     */
    public function test_article_update_get_page(): void
    {
        $user = User::factory()->has(Article::factory()->count(1))->accepted()->create();

        $article = $user->articles->first();

        $response = $this->actingAs($user)->get(route('admin.dashboard.edit-article', ['slug' => $article->slug]));

        $response->assertStatus(200);
    }

    /**
     * Test the update article post request is doable
     * when authenticated
     * 
     * @return void
     */
    public function test_article_update_post_request(): void
    {
        $user = User::factory()->accepted()->has(
            Article::factory(),
            'articles'
        )
            ->create();

        Storage::fake('test');

        $file = UploadedFile::fake()->image('avatar.jpg')->size(100);

        $tag = Tag::create([
            'title' => 'Health',
            'slug' =>  Str::slug(random_int(1000000000, 9999999999) . 'Health'),
            'user_id' => $user->id,
        ]);

        $article = Article::where('user_id', $user->id)->first();

        $response = $this->actingAs($user)
            ->post(route('admin.dashboard.edit-article', ['slug' =>  $article->slug]), [
                "title" => "Temp Article",
                "meta_description" => "Just a temporary article.",
                "description" => "<p>Just some temporary article.</p>",
                "image" => $file,
                "tags" => [$tag->id],
            ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('articles', [
            'title' => 'Temp Article',
        ]);
    }

    /**
     * Test the delete article post requset is 
     * doable when authenticated
     * 
     * @return void
     */
    public function test_delete_article_post_request(): void
    {
        $user = User::factory()->accepted()->has(
            Article::factory(),
            'articles'
        )
            ->create();

        $article = Article::where('user_id', $user->id)->first();

        $response = $this->actingAs($user)
            ->post(route('admin.dashboard.delete-article'), [
                'articleSlug' => $article->slug,
            ]);

        $response->assertStatus(302);

        $this->assertDatabaseMissing('articles', [
            'user_id' => $user->id,
        ]);
    }
}
