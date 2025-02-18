<?php

namespace App\Livewire\Users;

use App\Events\UserActivityEvent;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\Attributes\Validate;

class Delete extends Component
{
    public ?User $user;

    public string $username = '';

    #[Validate('required', message: 'You are required to enter the username to confirm deletion.')]
    #[Validate('same:username', message: 'The username you entered does not match the user\'s username.')]
    public string $confirm_username = '';

    public bool $is_confirmed = false;

    public bool $showModal = false;

    public function open(): void
    {
        $this->showModal = true;
    }

    public function mount($user_id): void
    {
        $this->user = User::findOrFail($user_id);
        $this->username = $this->user->username;
    }

    public function delete(): void
    {
        try
        {
            $this->user->delete();
        }
        catch (\Exception $e)
        {
            event(new UserActivityEvent(
                auth()->user(),
                'User deletion failed.',
                "User " . auth()->user()->username . " failed to delete user " . $this->user->username . ".",
                [
                    'user_id' => $this->user->id,
                    'user_username' => $this->user->username,
                ],
                Carbon::now()->toDateTimeString()
            ));

            session()->flash('error', 'User deletion failed.');
            $this->redirect(route('users.index'));
        }

        event(new UserActivityEvent(
            auth()->user(),
            'User successfully deleted.',
            "User " . auth()->user()->username . " deleted user " . $this->user->username . ".",
            [
                'user_id' => $this->user->id,
                'user_username' => $this->user->username,
            ],
            Carbon::now()->toDateTimeString()
        ));

        session()->flash('success', 'User successfully deleted.');
        $this->redirect(route('users.index'));
    }

    public function close(): void
    {
        $this->showModal = false;
        $this->reset(['confirm_username']);
        $this->resetErrorBag();
    }

    public function render(): View
    {
        return view('livewire.users.delete');
    }
}
