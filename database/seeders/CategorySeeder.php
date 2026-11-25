<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $parents = Category::factory()->count(5)->create();

        foreach ($parents as $parent) {
            Category::factory()->count(2)->create(['parent_id' => $parent->id]);
        }
    }
}