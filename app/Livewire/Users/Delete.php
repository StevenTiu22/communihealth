<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Delete extends Component
{
    public User $user;

    public bool $showDeleteModal = false;

    public function openUserDeleteModal(): void
    {
        $this->showDeleteModal = true;
    }

    public function mount($id): void
    {
        $this->user = User::findOrFail($id);
    }

    public function closeUserDeleteModal(): void
    {
        $this->showDeleteModal = false;
        $this->reset($this->user);
        $this->resetErrorBag();
    }

    public function render(): View
    {
        return view('livewire.users.delete');
    }
}
