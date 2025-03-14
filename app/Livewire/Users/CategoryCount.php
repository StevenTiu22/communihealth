<?php

namespace App\Livewire\Users;

use Livewire\Component;
use App\Models\User;

class CategoryCount extends Component
{
    public int $barangay_official_count;
    public int $bhw_count;
    public int $doctor_count;
    public int $deleted_user_count;

    public function mount(): void
    {
        $this->barangay_official_count = User::with('roles')->get()->filter(
            fn ($user) => $user->roles->where('name', 'barangay-official')->toArray()
        )->count();

        $this->bhw_count = User::with('roles')->get()->filter(
            fn ($user) => $user->roles->where('name', 'bhw')->toArray()
        )->count();

        $this->doctor_count = User::with('roles')->get()->filter(
            fn ($user) => $user->roles->where('name', 'doctor')->toArray()
        )->count();

        $this->deleted_user_count = User::onlyTrashed()->count();
    }

    public function render()
    {
        return view('livewire.users.category-count');
    }
}
