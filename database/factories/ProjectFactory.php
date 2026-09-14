<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = Str::ucfirst(fake()->unique()->words(4, true));

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'client_name' => null,
            'sector' => 'Corporate',
            'location' => 'Nairobi, Kenya',
            'year' => null,
            'summary' => fake()->sentence(14),
            'challenge' => fake()->paragraph(),
            'solution' => fake()->paragraph(),
            'outcome' => fake()->paragraph(),
            'cover_image' => '',
            'gallery' => [],
            'is_featured' => false,
            'sort_order' => fake()->numberBetween(1, 50),
        ];
    }

    public function featured(): static
    {
        return $this->state(fn (array $attributes): array => ['is_featured' => true]);
    }
}
