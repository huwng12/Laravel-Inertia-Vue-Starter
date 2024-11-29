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
        ]);
        Listing::factory(50)->create();
    }
}
