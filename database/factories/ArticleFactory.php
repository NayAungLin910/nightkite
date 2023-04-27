<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $fakeTitle = fake()->name();
        return [
            'title' => $fakeTitle,
            'slug' => Str::slug(random_int(1000000000, 9999999999) . $fakeTitle),
            'meta_description' => fake()->paragraph(),
            'description' => '<p>' . fake()->paragraph() . '</p>',
            'image' => '/default_images/nightkite_logo_transparent.webp' 
        ];
    }
}
