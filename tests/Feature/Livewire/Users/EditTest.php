<?php

namespace Livewire\Users;

use App\Livewire\Users\Edit as EditUserModal;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;
class EditTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed('RolesAndPermissionSeeder');

        $this->user = User::factory()->withRole('barangay-official')->create();
    }

    public function test_modal_renders_successfully()
    {
        Livewire::test(EditUserModal::class)
            ->assertStatus(200);
    }

    public function test_modal_appears_on_user_management()
    {
        $this->actingAs($this->user)
            ->get(route('users.index'))
            ->assertSeeLivewire(EditUserModal::class);
    }

    public function test_modal_closes_on_cancel()
    {
        Livewire::test(EditUserModal::class)
            ->call('open')
            ->assertSet('showModal', true)
            ->call('close')
            ->assertSet('showModal', false);
    }

    public function test_modal_can_update_barangay_official_information()
    {
        $this->actingAs($this->user);

        $user = User::factory()->unverified()->create();

        Livewire::test(EditUserModal::class, ['user' => $user])
            ->set('form.position', 'Kagawad')
            ->set('form.term_start', '2025-01-24')
            ->set('form.term_end', '2028-01-24')
            ->call('update')
            ->assertHasNoErrors()
            ->assertSessionHas('success', 'User updated successfully')
            ->assertSet('showModal', false);

        $this->assertNotNull($user->barangayOfficial());

        $this->assertDatabaseHas('barangay_officials', [
           'user_id' => $user->id,
            'position' => 'Kagawad',
            'term_start' => '2025-01-24',
            'term_end' => '2028-01-24'
        ]);
    }
}
