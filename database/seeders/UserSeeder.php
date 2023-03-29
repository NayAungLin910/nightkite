<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            "name" => "Nay Aung Lin",
            "image" => "/default_images/nightkite_logo_transparent.webp",
            "email" => "nayaunglin910@gmail.com",
            'email_verified_at' => now(),
            'description' => 'A junior web developer attending college who has a passion in developing laravel web applications',
            'password' => Hash::make('nightNightMario922*BladeRunner'),
            'remember_token' => Str::random(10),
            'role' => 3,
        ]);

        if ($user) {
            Tag::create([
                'title' => 'Health & Fitness',
                'slug' =>  Str::slug(random_int(1000000000, 9999999999) . 'Health & Fitness'),
                'user_id' => $user->id,
            ]);
            Tag::create([
                'title' => 'Sports',
                'slug' =>  Str::slug(random_int(1000000000, 9999999999) . 'Sports'),
                'user_id' => $user->id,
            ]);
            Tag::create([
                'title' => 'Coding',
                'slug' =>  Str::slug(random_int(1000000000, 9999999999) . 'Coding'),
                'user_id' => $user->id,
            ]);
        }
    }
}
