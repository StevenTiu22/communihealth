<?php

namespace App\Livewire\Users;

use App\Actions\UpdateUserInformation;
use App\Events\UserActivityEvent;
use App\Livewire\Forms\EditUserForm;
use App\Models\Specialization;
use App\Models\User;
use Carbon\Carbon;
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

    #[Validate('image', message: "Invalid file type. Only image files are allowed.")]
    #[Validate('max:2048', message: "File size too large. Max size allowed is 1MB.")]
    public mixed $new_profile_photo = null;

    public function mount($user_id): void
    {
        $this->user = User::find($user_id);

        // Fill the form with the existing basic information
        $this->form->user_id = $user_id;
        $this->form->fill($this->user->toArray());

        // Fill the form with the address information
        if ($this->user->address)
        {
            $this->form->fill($this->user->address->toArray());
        }

        $this->form->role = $this->user->getRoleNames()[0];

        // Fill the form with the existing role-based information
        if ($this->user->getRoleNames()[0] === 'barangay-official')
        {
            $this->form->fill($this->user->barangayOfficial->toArray());
        }
        else if ($this->user->getRoleNames()[0] === 'bhw')
        {
            $this->form->fill($this->user->bhw->toArray());
        }
        else
        {
            $this->form->license_number = $this->user->doctor->license_number;
            $this->form->specialization = $this->user->doctor->specializations->first()->id;
        }
    }

    public function open(): void
    {
        $this->showModal = true;
    }

    public function close(): void
    {
        $this->showModal = false;
        $this->form->resetErrorBag();
        $this->reset(['new_profile_photo']);
    }

    public function update(UpdateUserInformation $updater): void
    {
        // Photo handling
        if ($this->new_profile_photo)
            $this->user->updateProfilePhoto($this->new_profile_photo);

        // Validation
        $validated_data = $this->form->validate();

        try
        {
            $updater->update($this->user, $validated_data);
        }
        catch (\Exception $e)
        {
            event(new UserActivityEvent(
                auth()->user(),
                'Failed to update user information.',
                "User " . auth()->user()->username . " failed to update user information of user {$this->user->username}.",
                [
                    'data' => $validated_data,
                ],
                Carbon::now()->toDateTimeString()
            ));

            session()->flash('error', 'Failed to update user information.');
            $this->redirect(route('users.index'));
        }

        event(new UserActivityEvent(
            auth()->user(),
            'Updated user information.',
            "User " . auth()->user()->username . " updated user information of user {$this->user->username}.",
            [
                'data' => $validated_data,
            ],
            Carbon::now()->toDateTimeString()
        ));

        session()->flash('success', 'User information updated successfully.');
        $this->redirect(route('users.index'));
    }

    public function render(): View
    {
        $specializations = Specialization::all();

        return view('livewire.users.edit', [
            'specializations' => $specializations
        ]);
    }
}
