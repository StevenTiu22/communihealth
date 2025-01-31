<?php

namespace Tests\Feature\Livewire\Users;

use App\Livewire\Users\CreateUserModal;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

class CreateUserModalTest extends TestCase
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
}
