<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class DeleteUserModal extends Component
{
    public $showModal = false;
    public $user;

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function deleteUser()
    {
        if ($this->user) {
            $this->user->delete();
            $this->dispatch('userDeleted');
        }
        
        $this->closeModal();
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function render()
    {
        return view('livewire.delete-user-modal');
    }
}
