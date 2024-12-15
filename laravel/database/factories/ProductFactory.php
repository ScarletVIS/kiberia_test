<?php

namespace Database\Factories;
use App\Models\Category;
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
            'category_id' => fake()->randomDigitNotZero(),
            'name' => fake()->unique()->word,
            'price' => fake()->randomFloat(2, 1, 100),
            'quantity' => fake()->numberBetween(1, 50),
        ];
    }
}
