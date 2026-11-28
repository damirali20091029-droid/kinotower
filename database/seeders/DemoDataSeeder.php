<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Country;
use App\Models\Film;
use App\Models\Gender;
use App\Models\Rating;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $countries = Country::pluck('id');
        $categories = Category::pluck('id');
        $genders = Gender::pluck('id');

        $users = collect();
        for ($i = 0; $i < 5; $i++) {
            $users->push(User::create([
                'fio' => fake()->name(),
                'birthday' => fake()->date(),
                'gender_id' => $genders->random(),
                'email' => fake()->unique()->safeEmail(),
                'password' => 'password',
            ]));
        }

        for ($i = 1; $i <= 25; $i++) {
            $film = Film::create([
                'name' => 'Фильм ' . $i,
                'country_id' => $countries->random(),
                'duration' => fake()->numberBetween(60, 180),
                'year_of_issue' => fake()->numberBetween(1990, 2025),
                'age' => fake()->randomElement([0, 6, 12, 16, 18]),
                'link_video' => 'https://example.com/video/' . $i,
            ]);

            $film->categories()->attach($categories->random(2));

            Review::create([
                'film_id' => $film->id,
                'user_id' => $users->random()->id,
                'message' => fake()->sentence(8),
                'is_approved' => fake()->boolean() ? 1 : 0,
            ]);

            Rating::create([
                'film_id' => $film->id,
                'user_id' => $users->random()->id,
                'ball' => fake()->numberBetween(1, 10),
            ]);
        }
    }
}