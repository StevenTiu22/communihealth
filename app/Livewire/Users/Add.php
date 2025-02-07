<?php

namespace App\Livewire\Users;

use App\Actions\Fortify\CreateNewUser;
use App\Events\UserActivityEvent;
use App\Livewire\Forms\CreateUserForm;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;

class Add extends Component
{
    use WithFileUploads;

    public CreateUserForm $form;

    #[Validate('image', message: "The :attribute field must be an image.")]
    #[Validate('max:2048', message: "The :attribute field must not be greater than :max kilobytes.")]
    public mixed $photo = null;

    public bool $showModal = false;

    public function mount(): void
    {
        if (auth()->user()->cannot('create users'))
            abort(403, 'This action is unauthorized.');
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

    public function save(CreateNewUser $creator): void
    {
        // Photo upload
        if (!$this->photo)
            $this->form->profile_photo_path = storage_path('app/public/images/default-avatar.png');
        else
            $this->form->profile_photo_path = $this->photo->store('images', 'public');

        // Validation
        $validatedData = $this->validate($this->form);

        // Creation
        try
        {
            $creator->create($validatedData);

            UserActivityEvent::dispatch(
                auth()->user()->id,
                "User created.",
                ['data' => $validatedData],
                now()->toDateTimeString()
            );

            session()->flash('success', 'User created successfully!');
        }
        catch(\Exception $e)
        {
            session()->flash('error', 'Failed to create user. Please try again later.');

            UserActivityEvent::dispatch(
                auth()->user()->id,
                "User creation failed.",
                ['error' => $e->getMessage()],
                now()->toDateTimeString()
            );
        }

        $this->close();
    }

    public function render(): View
    {
        return view('livewire.users.add');
    }
}
