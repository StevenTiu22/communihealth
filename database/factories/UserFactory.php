<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'middle_name' => rand(0, 1) ? fake()->firstName() : null,
            'last_name' => fake()->lastName(),
            'birth_date' => fake()->date(),
            'sex' => fake()->randomElement(['0', '1']),
            'email' => fake()->unique()->safeEmail(),
            'username' => fake()->unique()->userName(),
            'contact_no' => fake()->phoneNumber(),
            'password' => static::$password ??= Hash::make('password'),
            'email_verified_at' => Carbon::parse(now()),
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'remember_token' => Str::random(10),
            'profile_photo_path' => null,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function unremembered(): static
    {
        return $this->state(fn (array $attributes) => [
            'remember_token' => null,
        ]);
    }

    public function withRole(string $role)
    {
        return $this->afterCreating(function (User $user) use ($role) {
            $user->syncRoles($role);
        });
    }

    /**
     * Indicate that the user should have a personal team.
     */
    public function withPersonalTeam(?callable $callback = null): static
    {
        if (! Features::hasTeamFeatures()) {
            return $this->state([]);
        }

        return $this->has(
            Team::factory()
                ->state(fn (array $attributes, User $user) => [
                    'name' => $user->name.'\'s Team',
                    'user_id' => $user->id,
                    'personal_team' => true,
                ])
                ->when(is_callable($callback), $callback),
            'ownedTeams'
        );
    }
}
