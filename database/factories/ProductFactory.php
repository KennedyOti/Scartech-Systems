<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
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
        $name = Str::ucfirst(fake()->unique()->words(3, true));

        return [
            'product_category_id' => ProductCategory::factory(),
            'name' => $name,
            'slug' => Str::slug($name),
            'brand' => fake()->company(),
            'model_number' => strtoupper(fake()->bothify('??-####')),
            'summary' => fake()->sentence(12),
            'description' => fake()->paragraph(),
            'specifications' => [['label' => 'Power', 'value' => '12V DC']],
            'features' => [fake()->sentence(4)],
            'is_featured' => false,
            'is_active' => false,
            'sort_order' => fake()->numberBetween(1, 50),
        ];
    }

    public function active(): static
    {
        return $this->state(fn (array $attributes): array => ['is_active' => true]);
    }

    public function featured(): static
    {
        return $this->state(fn (array $attributes): array => ['is_featured' => true]);
    }
}
