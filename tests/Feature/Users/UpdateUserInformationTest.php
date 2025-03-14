<?php

namespace Tests\Feature\Users;

use App\Actions\UpdateUserInformation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use function Laravel\Prompts\password;

class UpdateUserInformationTest extends TestCase
{
    use RefreshDatabase;
    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed('RolesAndPermissionSeeder');

        $this->admin = User::factory()->withRole('barangay-official')->create();
    }

    public function test_admin_can_update_basic_user_information(): void
    {
        $this->actingAs($this->admin);

        $user = User::factory()->withRole('bhw')->create();

        $action = app(UpdateUserInformation::class);

        $action->update($user, [
           'first_name' => 'John',
            'middle_name' => 'Doe',
            'last_name' => 'Smith',
            'birth_date' => '1990-01-01',
            'sex' => '1',
            'contact_no' => '639123456789',
            'password' => Hash::make('password'),
        ]);

        $this->assertDatabaseHas('users', [
            'first_name' => 'John',
            'middle_name' => 'Doe',
            'last_name' => 'Smith',
            'birth_date' => '1990-01-01',
            'sex' => '1',
            'contact_no' => '639123456789',
        ]);

        $this->assertTrue(Hash::check('password', $user->password));
    }
}
