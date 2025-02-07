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
        $this->actingAs($this->user);

        Livewire::test(CreateUserModal::class)
            ->set('form.first_name', 'john')
            ->set('form.middle_name', 'doe')
            ->set('form.last_name', 'smith')
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
            ->set('form.city', 'San Juan')
            ->set('form.province', 'Marilag')
            ->set('form.region', 'Region IX')
            ->set('form.country', 'Philippines')
            ->set('form.role', 'barangay-official')
            ->set('form.position', 'Barangay Captain')
            ->set('form.term_start', '2021-01-01')
            ->set('form.term_end', '2023-01-01')
            ->call('save')
            ->assertHasNoErrors()
            ->assertDispatched('user-created')
            ->assertSet('showModal', false);


        $this->assertDatabaseHas('users', [
                'first_name' => 'john',
                'middle_name' => 'doe',
                'last_name' => 'smith',
                'birth_date' => '1990-01-01',
                'sex' => '0',
                'contact_no' => '639123456789',
                'email' => 'johndoe@gmail.com',
                'username' => 'johndoe',
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

        $this->assertTrue($user->hasRole('barangay-official'));

        $this->assertNotNull($user->barangayOfficial());

        $this->assertDatabaseHas('barangay_officials', [
                'user_id' => $user->id,
                'position' => 'Barangay Captain',
                'term_start' => '2021-01-01',
                'term_end' => '2023-01-01',
        ]);
    }

    public function test_modal_can_create_bhw()
    {
        $this->actingAs($this->user);

        Livewire::test(CreateUserModal::class)
            ->set('form.first_name', 'john')
            ->set('form.middle_name', 'doe')
            ->set('form.last_name', 'smith')
            ->set('form.birth_date', '1990-01-01')
            ->set('form.sex', '0')
            ->set('form.contact_no', '+639123456789')
            ->set('form.email', 'johndoe12@gmail.com')
            ->set('form.username', 'johndoe1')
            ->set('form.password', 'password')
            ->set('form.confirm_password', 'password')
            ->set('form.profile_photo_path', 'images/default-avatar.png')
            ->set('form.house_number', '123')
            ->set('form.street', 'Main Street')
            ->set('form.barangay', 'Barangay 1')
            ->set('form.city', 'San Juan')
            ->set('form.province', 'Marilag')
            ->set('form.region', 'Region IX')
            ->set('form.country', 'Philippines')
            ->set('form.role', 'bhw')
            ->set('form.certification_no', '123456789')
            ->set('form.bhw_barangay', 'Barangay 1')
            ->call('save')
            ->assertHasNoErrors()
            ->assertDispatched('user-created')
            ->assertSet('showModal', false);


        $this->assertDatabaseHas('users', [
            'first_name' => 'john',
            'middle_name' => 'doe',
            'last_name' => 'smith',
            'birth_date' => '1990-01-01',
            'sex' => '0',
            'contact_no' => '639123456789',
            'email' => 'johndoe12@gmail.com',
            'username' => 'johndoe1',
            'profile_photo_path' => 'images/default-avatar.png',
        ]);

        $user = User::where('username', 'johndoe1')->first();

        $this->assertNotNull($user->address);

        $this->assertDatabaseHas('addresses', [
            'house_number' => '123',
            'street' => 'Main Street',
            'barangay' => 'Barangay 1',
            'province' => 'Marilag',
            'region' => 'Region IX',
            'country' => 'Philippines',
        ]);

        $this->assertTrue($user->hasRole('bhw'));

        $this->assertNotNull($user->bhw());

        $this->assertDatabaseHas('bhws', [
            'user_id' => $user->id,
            'certification_no' => '123456789',
            'barangay' => 'Barangay 1',
        ]);
    }

    public function test_modal_can_create_doctor()
    {
        $this->actingAs($this->user);

        Livewire::test(CreateUserModal::class)
            ->set('form.first_name', 'john')
            ->set('form.middle_name', 'doe')
            ->set('form.last_name', 'smith')
            ->set('form.birth_date', '1990-01-01')
            ->set('form.sex', '0')
            ->set('form.contact_no', '+639123456789')
            ->set('form.email', 'johndoe23@gmail.com')
            ->set('form.username', 'johndoe2')
            ->set('form.password', 'password')
            ->set('form.confirm_password', 'password')
            ->set('form.profile_photo_path', 'images/default-avatar.png')
            ->set('form.house_number', '123')
            ->set('form.street', 'Main Street')
            ->set('form.barangay', 'Barangay 1')
            ->set('form.city', 'San Juan')
            ->set('form.province', 'Marilag')
            ->set('form.region', 'Region IX')
            ->set('form.country', 'Philippines')
            ->set('form.role', 'doctor')
            ->set('form.license_number', '1234567')
            ->set('form.specialization', 'General Medicine')
            ->call('save')
            ->assertHasNoErrors()
            ->assertDispatched('user-created')
            ->assertSet('showModal', false);


        $this->assertDatabaseHas('users', [
            'first_name' => 'john',
            'middle_name' => 'doe',
            'last_name' => 'smith',
            'birth_date' => '1990-01-01',
            'sex' => '0',
            'contact_no' => '639123456789',
            'email' => 'johndoe23@gmail.com',
            'username' => 'johndoe2',
            'profile_photo_path' => 'images/default-avatar.png',
        ]);

        $user = User::where('username', 'johndoe2')->first();

        $this->assertNotNull($user->address);

        $this->assertDatabaseHas('addresses', [
            'house_number' => '123',
            'street' => 'Main Street',
            'barangay' => 'Barangay 1',
            'province' => 'Marilag',
            'region' => 'Region IX',
            'country' => 'Philippines',
        ]);

        $this->assertTrue($user->hasRole('doctor'));

        $this->assertNotNull($user->doctor());

        $this->assertDatabaseHas('doctors', [
            'user_id' => $user->id,
            'license' => '1234567',
        ]);

        $this->assertNotNull($user->doctor->specializations());

        $this->assertEquals('General Medicine', $user->doctor->specializations()->first()->name);

        $this->assertDatabaseHas('doctor_specializations', [
            'doctor_id' => $user->doctor->id,
            'specialization_id' => 1,
        ]);
    }
}
