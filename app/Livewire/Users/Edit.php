<?php

namespace App\Livewire\Users;

use App\Livewire\Forms\EditUserForm;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Edit extends Component
{
    public bool $showModal = false;
    public EditUserForm $form;

    public function mount($user_id): void
    {
        $this->form->user = User::findOrFail($user_id);
    }

    public function open(): void
    {
        $this->showModal = true;
    }

    public function close(): void
    {
        $this->showModal = false;
        $this->form->reset();
        $this->form->resetErrorBag();
    }

    public function render(): View
    {
        return view('livewire.users.edit');
    }
}
