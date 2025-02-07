<?php

namespace Tests\Feature\Livewire\Users;

use App\Livewire\Users\Add as CreateUserModal;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;

class AddTest extends TestCase
{
    protected ?User $user;
    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->withRole('barangay-official')->create();
    }

    public function test_modal_renders_successfully()
    {
        Livewire::test(CreateUserModal::class)
            ->assertStatus(200);
    }

    public function test_modal_appears_on_user_management()
    {
        $this->actingAs($this->user)
            ->get(route('barangay-official.users'))
            ->assertSeeLivewire(CreateUserModal::class);
    }

    public function test_modal_closes_on_cancel()
    {
        Livewire::test(CreateUserModal::class)
            ->call('open')
            ->assertSet('showModal', true)
            ->call('close')
            ->assertSet('showModal', false);
    }

    public function test_modal_can_create_barangay_official()
    {
        Livewire::test(CreateUserModal::class)
            ->set('form.first_name', 'John')
            ->set('form.middle_name', 'Doe')
            ->set('form.last_name', 'Smith')
            ->set('form.birth_date', '1990-01-01')
            ->set('form.sex', '0')
            ->set('form.contact_no', '+639123456789')
            ->set('form.email', 'johndoe@gmail.com')
            ->set('form.username', 'johndoe')
            ->set('form.password', 'password')
            ->set('form.confirm_password', 'password')
            ->set('form.profile_photo_path', 'images/default-avatar.png')
            ->set('form.house_number', '123')
            ->set('form.street', 'Main Street')
            ->set('form.barangay', 'Barangay 1')
            ->set('form.province', 'Marilag')
            ->set('form.region', 'Region IX')
            ->set('form.country', 'Philippines')
            ->set('form.role', 'barangay-official')
            ->set('form.position', 'Barangay Captain')
            ->set('form.term_start', '2021-01-01')
            ->set('form.term_end', '2023-01-01')
            ->call('save')
            ->assertHasNoErrors()
            ->assertSessionHas('success', 'User registered successfully!')
            ->assertSet('showModal', false);


        $this->assertDatabaseHas('users', [
                'first_name' => 'John',
                'middle_name' => 'Doe',
                'last_name' => 'Smith',
                'birth_date' => '1990-01-01',
                'sex' => '0',
                'contact_no' => '+639123456789',
                'email' => 'johndoe@gmail.com',
                'username' => 'johndoe',
                'password' => Hash::make('password'),
                'profile_photo_path' => 'images/default-avatar.png',
        ]);

        $user = User::where('username', 'johndoe')->first();

        $this->assertNotNull($user->address);

        $this->assertDatabaseHas('addresses', [
                'house_number' => '123',
                'street' => 'Main Street',
                'barangay' => 'Barangay 1',
                'province' => 'Marilag',
                'region' => 'Region IX',
                'country' => 'Philippines',
        ]);

        $this->assertTrue($user->hasRole('barangay_official'));

        $this->assertNotNull($user->barangayOfficial);

        $this->assertDatabaseHas('barangay_officials', [
                'user_id' => $user->id,
                'position' => 'Barangay Captain',
                'term_start' => '2021-01-01',
                'term_end' => '2023-01-01',
        ]);
    }
}
