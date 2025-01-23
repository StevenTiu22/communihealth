<?php

namespace Tests\Unit;

use App\Models\User;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Database\QueryException;
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
        $this->expectException(QueryException::class);

        User::factory()->make([
            'first_name' => null,
        ]);
    }

    public function test_first_name_must_not_be_empty(): void
    {
        $this->expectException(QueryException::class);

        User::factory()->make([
            'first_name' => '',
        ]);
    }

    public function test_last_name_must_not_be_null(): void
    {
        $this->expectException(QueryException::class);

        User::factory()->make([
            'last_name' => null,
        ]);
    }

    public function test_last_name_must_not_be_empty(): void
    {
        $this->expectException(QueryException::class);

        User::factory()->make([
            'last_name' => '',
        ]);
    }

    public function test_birth_date_must_not_be_null(): void
    {
        $this->expectException(QueryException::class);

        User::factory()->make([
            'birth_date' => null,
        ]);
    }

    public function test_birth_date_must_not_be_empty(): void
    {
        $this->expectException(QueryException::class);

        User::factory()->make([
            'birth_date' => '',
        ]);
    }

    public function test_birth_date_must_be_a_date(): void
    {
        $this->expectException(InvalidFormatException::class);

        User::factory()->make([
            'birth_date' => 'Not a date',
        ]);
    }

    public function test_user_type_must_be_valid(): void
    {
        $this->expectException(QueryException::class);

        $user = User::factory()->make([
            'user_type' => '10',
        ]);
    }
}
