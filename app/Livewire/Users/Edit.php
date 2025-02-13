<?php

namespace App\Livewire\Users;

use App\Livewire\Forms\EditUserForm;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Edit extends Component
{
    public bool $showModal = false;
    public EditUserForm $form;

    #[Validate('image', message: "The :attribute field must be an image.")]
    #[Validate('max:2048', message: "The :attribute field must not be greater than :max kilobytes.")]
    public mixed $edit_photo;

    public function mount($user_id): void
    {
        $this->form->edit_user = User::findOrFail($user_id);

        $this->form->edit_first_name = $this->form->edit_user->first_name;
        $this->form->edit_middle_name = $this->form->edit_user->middle_name ?? '';
        $this->form->edit_last_name = $this->form->edit_user->last_name;
        $this->form->edit_birth_date = Carbon::parse($this->form->edit_user->birth_date)->format('Y-m-d');
        $this->form->edit_sex = match($this->form->edit_user->sex) {
            'male' => 0,
            'female' => 1,
        };
        $this->form->edit_contact_no = $this->form->edit_user->contact_no;
        $this->form->edit_email = $this->form->edit_user->email;
        $this->form->edit_username = $this->form->edit_user->username;

        $this->form->edit_house_number = $this->form->edit_user->address->house_number ?? '';
        $this->form->edit_street = $this->form->edit_user->address->street ?? '';
        $this->form->edit_barangay = $this->form->edit_user->address->barangay ?? '';
        $this->form->edit_city = $this->form->edit_user->address->city ?? '';
        $this->form->edit_province = $this->form->edit_user->address->province ?? '';
        $this->form->edit_region = $this->form->edit_user->address->region ?? '';
        $this->form->edit_country = $this->form->edit_user->address->country ?? '';

        $this->form->edit_role = $this->form->edit_user->getRoleNames()[0];

        if ($this->form->edit_role === 'barangay_official')
        {
            $this->form->edit_position = $this->form->edit_user->barangayOfficial()->position ?? '';
            $this->form->edit_term_start = $this->form->edit_user->barangayOfficial()->term_start ?? '';
            $this->form->edit_term_end = $this->form->edit_user->barangayOfficial()->term_end ?? '';
        }
        else if ($this->form->edit_role === 'bhw')
        {
            $this->form->edit_certification_no = $this->form->edit_user->bhw()->certification_no ?? '';
            $this->form->edit_bhw_barangay = $this->form->edit_user->bhw()->bhw_barangay ?? '';
        }
        else if ($this->form->edit_role === 'doctor')
        {
            $this->form->edit_license_number = $this->form->edit_user->doctor()->license_number ?? '';
            $this->form->edit_specialization = $this->form->edit_user->doctor->specializations()->name ?? '';
        }

        $this->form->edit_profile_photo_path = $this->form->edit_user->profile_photo_path;
        $this->edit_photo = $this->form->edit_user->profile_photo_path;
    }

    public function open(): void
    {
        $this->showModal = true;
    }

    public function close(): void
    {
        $this->showModal = false;
        $this->reset('edit_photo');
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
