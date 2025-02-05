<?php

namespace App\Livewire\Users;

use App\Livewire\Forms\UserForm;
use App\Models\Address;
use App\Models\ParentInfo;
use App\Models\Specialization;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;

class Add extends Component
{
    use WithFileUploads;

    public UserForm $form;

    #[Validate('image', message: "The :attribute field must be an image.")]
    #[Validate('max:2048', message: "The :attribute field must not be greater than :max kilobytes.")]
    public mixed $photo = null;

    public bool $showModal = false;

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

    public function save(): RedirectResponse
    {
        return response()->redirectToRoute('users.index');
    }

    public function render(): View
    {
        return view('livewire.users.add');
    }
}
