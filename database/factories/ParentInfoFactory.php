<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ParentInfo>
 */
class ParentInfoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName(),
            'middle_name' => $this->faker->optional(0.7)->lastName(),
            'last_name' => $this->faker->lastName(),
            'philhealth_no' => sprintf("%02d-%09d-%d", 
                $this->faker->numberBetween(10, 99),
                $this->faker->numberBetween(100000000, 999999999),
                $this->faker->numberBetween(1, 9)
            ),
            'status' => $this->faker->randomElement(['Mother', 'Father'])
        ];
    }
}
