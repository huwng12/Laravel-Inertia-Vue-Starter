<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Listing;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(7)->create();
        Category::insert([
            ['name' => 'World', 'status' => 1],
            ['name' => 'Business', 'status' => 1],
            ['name' => 'Tech', 'status' => 1],
            ['name' => 'Health', 'status' => 1],
            ['name' => 'Sport', 'status' => 1],
            ['name' => 'Science', 'status' => 1],
            ['name' => 'Politics', 'status' => 1],
            ['name' => 'Entertainment', 'status' => 1],
            ['name' => 'Education', 'status' => 1],
            ['name' => 'Lifestyles', 'status' => 1],
            ['name' => 'Travel', 'status' => 1],
            ['name' => 'Real Property', 'status' => 1],
            ['name' => 'Podcasts', 'status' => 1],
            ['name' => 'Food', 'status' => 1],
            ['name' => 'Relax', 'status' => 1],
        ]);
        Listing::factory(50)->create();
    }
}
