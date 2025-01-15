<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class ProfilePage extends Component
{
    use WithFileUploads;

    public $user;
    public $first_name;
    public $last_name;
    public $email;
    public $contact_number;
    public $profile_photo;
    public $new_profile_photo;

    public function mount()
    {
        $this->user = Auth::user();
        $this->first_name = $this->user->first_name;
        $this->last_name = $this->user->last_name;
        $this->email = $this->user->email;
        $this->contact_number = $this->user->contact_number;
        $this->profile_photo = $this->user->profile_photo_path;
    }

    protected function rules()
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->user->id,
            'contact_number' => 'required|string|max:11',
            'new_profile_photo' => 'nullable|image|max:1024'
        ];
    }

    public function updateProfile()
    {
        $this->validate();

        if ($this->new_profile_photo) {
            $path = $this->new_profile_photo->store('profile-photos', 'public');
            $this->user->profile_photo_path = $path;
        }

        $this->user->update([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'contact_number' => $this->contact_number,
        ]);

        session()->flash('message', 'Profile updated successfully.');
    }

    public function render()
    {
        return view('livewire.profile-page')->layout('layouts.app');
    }
} 