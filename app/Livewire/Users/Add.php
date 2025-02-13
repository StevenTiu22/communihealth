<?php

namespace App\Livewire\Users;

use App\Actions\CreateNewUser;
use App\Events\UserActivityEvent;
use App\Livewire\Forms\CreateUserForm;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Livewire\Component;
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

    /*public function mount(): void
    {
        if (auth()->user()->cannot('create users'))
            abort(403, 'This action is unauthorized.');
    }*/

    public function open(): void
    {
        $this->showModal = true;
    }

    public function close(): void
    {
        $this->showModal = false;
        $this->reset('photo');
        $this->form->resetErrorBag();
    }

    public function save(CreateNewUser $creator): void
    {
        // Photo upload
        if ($this->photo === null)
            $this->form->profile_photo_path = 'images/default-avatar.png';
        else
            $this->form->profile_photo_path = $this->photo->store('images', 'public');

        // Validation
        $validatedData = $this->form->validate();

        // Creation
        try
        {
            $user = $creator->create($validatedData);

            UserActivityEvent::dispatch(
                auth()->id(),
                "Successful user creation",
                "User {auth()->user()->username} created user {$user->username}.",
                [
                    'user' => $user->id,
                    'data' => $validatedData,
                ],
                now()->toDateTimeString()
            );

            event(new Registered($user));
        }
        catch(\Exception $e)
        {
            Log::error($e->getMessage());

            UserActivityEvent::dispatch(
                auth()->id(),
                "Failed user creation",
                "User {auth()->user()->username} failed to create user.",
                ['error' => $e->getMessage()],
                now()->toDateTimeString()
            );

            session()->flash('message', 'User creation failed.');

            $this->redirect('/users');
        }

        session()->flash('success', 'User created successfully!');

        $this->redirect('/users');
    }

    public function render(): View
    {
        return view('livewire.users.add');
    }
}
