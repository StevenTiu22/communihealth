<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_be_created(): void
    {
        $user = User::factory()->create();

        $this->assertInstanceOf(User::class, $user);
        $this->assertNotNull($user->id);
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => $user->email,
            'username' => $user->username,
        ]);
    }

    public function test_first_name_must_not_be_null(): void
    {
        $this->expectException(ValidationException::class);

        $attributes = User::factory()->make([
            'first_name' => null,
        ])->toArray();

        User::make($attributes);
    }

    public function test_first_name_must_not_be_empty(): void
    {
        $this->expectException(ValidationException::class);

        $attributes = User::factory()->make([
            'first_name' => '',
        ])->toArray();

        User::make($attributes);
    }

    public function test_last_name_must_not_be_null(): void
    {
        $this->expectException(ValidationException::class);

        $attributes = User::factory()->make([
            'last_name' => null,
        ])->toArray();

        User::make($attributes);
    }

    public function test_last_name_must_not_be_empty(): void
    {
        $this->expectException(ValidationException::class);

        $attributes = User::factory()->make([
            'last_name' => '',
        ])->toArray();

        User::make($attributes);
    }

    public function test_birth_date_must_not_be_null(): void
    {
        $this->expectException(ValidationException::class);

        $attributes = User::factory()->make()->toArray();
        $attributes['birth_date'] = null;

        User::make($attributes);
    }

    public function test_birth_date_must_not_be_empty(): void
    {
        $this->expectException(ValidationException::class);

        $attributes = User::factory()->make()->toArray();
        $attributes['birth_date'] = '';

        User::make($attributes);
    }

    public function test_birth_date_must_be_a_date(): void
    {
        $this->expectException(ValidationException::class);

        $attributes = User::factory()->make()->toArray();
        $attributes['birth_date'] = 'not-a-date';

        User::make($attributes);
    }

    public function test_user_type_must_be_valid(): void
    {
        $this->expectException(ValidationException::class);

        $attributes = User::factory()->make([
            'user_type' => '10',
        ])->toArray();

        User::make($attributes);
    }
}
