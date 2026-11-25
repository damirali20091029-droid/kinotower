<?php

namespace Database\Factories;

use App\Models\Gender;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'fio' => fake()->name(),
            'birthday' => fake()->date(),
            'gender_id' => Gender::query()->inRandomOrder()->value('id'),
            'email' => fake()->unique()->safeEmail(),
            'password' => 'password',
        ];
    }
}