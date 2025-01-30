<?php

namespace Tests\Feature\Users;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CreateUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_barangay_officials_can_create_users_with_roles(): void
    {
        $user = User::factory()->withRole('barangay-official')->create();

        $this->actingAs($user);

        $userData = [
            'first_name' => 'John',
            'middle_name' => 'Matthew',
            'last_name' => 'Doe',
            'birth_date' => '1990-01-01',
            'sex' => '0',
            'email' => 'johndoe@gmail.com',
            'username' => 'johndoe12',
            'contact_no' => '09123456789',
            'password' => 'password',
            'role' => 'bhw'
        ];

        Livewire::test(AddUserForm::class)
            ->set('first_name', $userData['first_name'])
            ->set('middle_name', $userData['middle_name'])
            ->set('last_name', $userData['last_name'])
            ->set('birth_date', $userData['birth_date'])
            ->set('sex', $userData['sex'])
            ->set('email', $userData['email'])
            ->set('username', $userData['username'])
            ->set('contact_no', $userData['contact_no'])
            ->set('password', $userData['password'])
            ->set('role', $userData['role'])
            ->call('save')
            ->assertHasNoErrors()
            ->assertDispatched('user-added')
            ->assertRedirect('/barangay-official/users');


        // Assert the user was created with correct data
        $this->assertDatabaseHas('users', [
            'first_name' => $userData['first_name'],
            'middle_name' => $userData['middle_name'],
            'last_name' => $userData['last_name'],
            'birth_date' => $userData['birth_date'],
            'sex' => $userData['sex'],
            'email' => $userData['email'],
            'username' => $userData['username'],
            'contact_no' => $userData['contact_no'],
        ]);

        $createdUser = User::where('email', $userData['email'])->first();
        $this->assertTrue($createdUser->hasRole('bhw'), 'User should have a role of bhw');
    }
}
