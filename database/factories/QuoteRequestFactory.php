<?php

namespace Database\Factories;

use App\Models\QuoteRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<QuoteRequest>
 */
class QuoteRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'phone' => '+254 700 000 000',
            'company' => fake()->company(),
            'location' => 'Nairobi',
            'site_type' => fake()->randomElement(QuoteRequest::SITE_TYPES),
            'timeline' => fake()->randomElement(QuoteRequest::TIMELINES),
            'details' => fake()->paragraph(),
            'needs_site_survey' => fake()->boolean(),
            'status' => 'new',
        ];
    }
}
