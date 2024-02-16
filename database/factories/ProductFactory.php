<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->text(50),
            'description' => fake()->text(500),
            'product_image' =>fake()->imageUrl(null,null,'product'),
            'price' => fake()->randomNumber(3),
            'category_id' => random_int(1, 10),

        ];
    }
}