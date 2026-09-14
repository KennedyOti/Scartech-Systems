<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'logo' => 'images/clients/example.png',
            'logo_width' => 400,
            'logo_height' => 200,
            'sector' => 'Corporate',
            'is_featured' => false,
            'sort_order' => fake()->numberBetween(1, 50),
        ];
    }

    public function withoutLogo(): static
    {
        return $this->state(fn (array $attributes): array => ['logo' => null, 'logo_width' => null, 'logo_height' => null]);
    }

    public function featured(): static
    {
        return $this->state(fn (array $attributes): array => ['is_featured' => true]);
    }
}
