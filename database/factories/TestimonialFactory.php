<?php

namespace Database\Factories;

use App\Models\Testimonial;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Testimonial>
 */
class TestimonialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'author_name' => fake()->name(),
            'author_role' => fake()->jobTitle(),
            'company' => fake()->company(),
            'quote' => fake()->sentence(20),
            'is_active' => false,
            'sort_order' => fake()->numberBetween(1, 50),
        ];
    }
}
