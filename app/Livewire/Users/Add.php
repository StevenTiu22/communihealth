<?php

namespace App\Livewire\Users;

use App\Livewire\Forms\UserForm;
use App\Models\Address;
use App\Models\ParentInfo;
use App\Models\Specialization;
use App\Models\User;
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
    }


    public function save()
    {
        $this->validate();

        try {

            $path = $this->profile_photo ? $this->profile_photo->store('images', 'public') : 'images/default-avatar.png';

            DB::beginTransaction();

            $user = User::create([
                'first_name' => $this->first_name,
                'middle_name' => $this->middle_name,
                'last_name' => $this->last_name,
                'birth_date' => $this->birth_date,
                'gender' => $this->gender,
                'contact_number' => $this->contact_number,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'role' => $this->role,
                'profile_photo_path' => $path
            ]);

            $address = Address::firstOrCreate([
                'house_number' => $this->house_number,
                'barangay' => $this->barangay,
                'street' => $this->street,
                'city' => $this->city
            ]);

            $user->addresses()->attach($address->id);

            // Doctor
            if ($this->role == '1') {
                $doctor = $user->doctor()->create([
                    'license_number' => $this->license_number
                ]);

                $specialization = Specialization::firstOrCreate([
                    'name' => $this->specialization
                ]);

                $doctor->specializations()->attach($specialization->id);
            }

            // Patient
            if ($this->role == '2') {
                $patient = $user->patient()->create([
                    'is_NHTS' => $this->is_NHTS,
                    'is_4ps' => $this->is_4ps
                ]);

                // Create mother's info
                $mother = ParentInfo::create([
                    'first_name' => $this->mother_first_name,
                    'middle_name' => $this->mother_middle_name,
                    'last_name' => $this->mother_last_name,
                    'contact_number' => $this->mother_contact_number,
                    'status' => 'mother'
                ]);

                // Create father's info
                $father = ParentInfo::create([
                    'first_name' => $this->father_first_name,
                    'middle_name' => $this->father_middle_name,
                    'last_name' => $this->father_last_name,
                    'contact_number' => $this->father_contact_number,
                    'status' => 'father'
                ]);

                // Attach parents to patient if they exist
                if ($mother) {
                    $patient->parents()->attach($mother->id);
                }
                if ($father) {
                    $patient->parents()->attach($father->id);
                }
            }

            // BHW
            if ($this->role == '3') {
                $user->bhw()->create([
                    'local_government_unit' => $this->local_government_unit,
                    'issuance_date' => $this->issuance_date
                ]);
            }

            // Barangay Official
            if ($this->role == '4') {
                $user->barangayOfficial()->create([
                    'position' => $this->position,
                    'term_start' => $this->term_start,
                    'term_end' => $this->term_end
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
        }

        if ($user) {
            session()->flash('success', 'User created successfully.');
            $this->reset();
            $this->redirectRoute('user-accounts.index');
        } else {
            session()->flash('error', 'Failed to create user. Please try again.');
        }
    }

    public function render(): View
    {
        return view('livewire.users.add');
    }
}
