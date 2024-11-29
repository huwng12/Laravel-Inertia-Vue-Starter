<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Listing>
 */
class ListingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => fake()->randomElement([1, 2, 3, 4, 5, 6, 7]),
            'category_id' => fake()->randomElement([1, 2, 3, 4, 5]),
            'title' => fake()->sentence(10),
            'desc' => fake()->sentence(20),
            'email' => fake()->email,
            'link' => fake()->url,
            'tags' => fake()->randomElement([
                'world',
                'world,business',
                'tech',
                'biz,tech',
                'tech,biz,world'
            ]),
            'approved' => 1,

        ];
    }
}
