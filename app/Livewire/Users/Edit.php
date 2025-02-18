<?php

namespace App\Livewire\Users;

use App\Livewire\Forms\EditUserForm;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public bool $showModal = false;
    public ?User $user;
    public EditUserForm $form;

    #[Validate('image', message: "The :attribute field must be an image.")]
    #[Validate('max:2048', message: "The :attribute field must not be greater than :max kilobytes.")]
    public mixed $new_profile_photo = null;

    public function mount($user_id): void
    {
        $this->user = User::find($user_id);

        $this->form->fill($this->user->toArray());
    }

    public function open(): void
    {
        $this->showModal = true;
    }

    public function close(): void
    {
        $this->showModal = false;
        $this->reset(['new_profile_photo']);
        $this->form->resetErrorBag();
    }

    public function update(): void
    {

    }

    public function render(): View
    {
        return view('livewire.users.edit');
    }
}
