<?php

namespace Database\Factories;

use App\Models\ContactMessage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ContactMessage>
 */
class ContactMessageFactory extends Factory
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
            'subject' => 'General enquiry',
            'message' => fake()->paragraph(),
            'source' => 'contact',
            'is_read' => false,
        ];
    }
}
