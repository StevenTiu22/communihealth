<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 */
class PatientFactory extends Factory
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
            'gender' => $this->faker->randomElement(['0', '1']),
            'birth_date' => $this->faker->dateTimeBetween('-50 years', '-1 year'),
            'contact_number' => '09' . $this->faker->numerify('#########'),
            'is_4ps' => $this->faker->boolean(30), // 30% chance of being true
            'is_NHTS' => $this->faker->boolean(30),
            'profile_photo_path' => 'images/default-avatar.png'
        ];
    }
}
