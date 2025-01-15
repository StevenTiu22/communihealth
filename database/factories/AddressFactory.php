<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'house_number' => $this->faker->buildingNumber(),
            'street' => $this->faker->streetName(),
            'barangay' => 'Barangay ' . $this->faker->numberBetween(1, 100),
            'city' => $this->faker->city()
        ];
    }
}
