<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = Str::ucfirst(fake()->unique()->words(2, true));

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'icon' => 'network',
            'tagline' => fake()->sentence(6),
            'summary' => fake()->paragraph(),
            'body' => '<p>'.fake()->paragraph().'</p>',
            'capabilities' => [
                ['title' => 'Site survey', 'description' => fake()->sentence()],
                ['title' => 'Installation', 'description' => fake()->sentence()],
                ['title' => 'Maintenance', 'description' => fake()->sentence()],
            ],
            'deliverables' => [fake()->sentence(4)],
            'applications' => ['Corporate offices', 'Schools'],
            'brands' => [],
            'sort_order' => fake()->numberBetween(1, 50),
            'is_featured' => false,
            'is_active' => true,
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes): array => ['is_active' => false]);
    }
}
