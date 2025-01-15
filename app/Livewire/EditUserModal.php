<?php

namespace App\Livewire;

use Livewire\Attributes\Validate;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Specialization;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class EditUserModal extends Component
{
    // Attributes
    public $user;

    public $role = "";

    #[Validate(['nullable', 'required_if:role,1', 'alpha_num', 'string'])]
    public $license_number;

    #[Validate(['nullable', 'required_if:role,1', 'alpha', 'string'])]
    public $specialization;

    #[Validate(['required', 'string', 'alpha', 'max:255'])]
    public $first_name;

    #[Validate(['nullable', 'string', 'alpha', 'max:255'])]
    public $middle_name;

    #[Validate(['required', 'string', 'alpha', 'max:255'])]
    public $last_name;

    #[Validate(['required', 'string', 'email', 'unique:users,email'])]
    public $email;

    #[Validate(['required', 'numeric', 'digits:11'])]
    public $contact_number;

    #[Validate(['required', 'date', 'before:today'])]
    public $birth_date;

    #[Validate(['required'])]
    public $gender;

    #[Validate(['required', 'string', 'regex:/^[a-zA-Z0-9\-\. ]+$/'])]
    public $house_number;

    #[Validate(['required', 'string', 'regex:/^[a-zA-Z0-9\-\. ]+$/'])]
    public $street;

    #[Validate(['required', 'string', 'regex:/^[a-zA-Z0-9\-\. ]+$/'])]
    public $barangay;

    #[Validate(['required', 'string', 'alpha'])]
    public $city;

    public $showModal = false;

    protected $listeners = ['openEditModal'];

    public function openEditModal($userId)
    {
        $this->reset();
        $this->showModal = true;

        $this->user = User::findOrFail($userId);
        $this->role = $this->user->role;

        if ($this->role == "Doctor")
        {
            $this->license_number = $this->user->doctor->license_number;
            $this->specialization = $this->user->doctor->specializations()->first()->name;
        }

        $this->first_name = $this->user->first_name;
        $this->middle_name = $this->user->middle_name;
        $this->last_name = ucfirst(strtolower($this->user->last_name));
        $this->email = $this->user->email;
        $this->contact_number = $this->user->contact_number;
        $this->birth_date = Carbon::parse($this->user->birth_date)->format('Y-m-d');
        $this->gender = $this->user->gender;
        $this->house_number = $this->user->addresses->first()->house_number;
        $this->street = $this->user->addresses->first()->street;
        $this->barangay = $this->user->addresses->first()->barangay;
        $this->city = $this->user->addresses->first()->city;
    }

    public function save()
    {
        $this->validate();

        try {
            DB::beginTransaction();

            $this->user->update([
                'first_name' => $this->first_name,
                'middle_name' => $this->middle_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'contact_number' => $this->contact_number,
                'birth_date' => $this->birth_date,
                'gender' => $this->gender,
                'role' => $this->role,
            ]);

            $address = $this->user->addresses()->first();
            $address->update([
                'house_number' => $this->house_number,
                'street' => $this->street,
                'barangay' => $this->barangay,
                'city' => $this->city,
            ]);

            if ($this->role === 'Doctor') {
                $doctor = $this->user->doctor;
                if (!$doctor) {
                    $doctor = Doctor::create([
                        'user_id' => $this->user->id,
                        'license_number' => $this->license_number,
                    ]);
                } else {
                    $doctor->update([
                        'license_number' => $this->license_number,
                    ]);
                }

                $specialization = Specialization::firstOrCreate(['name' => $this->specialization]);
                $doctor->specializations()->sync([$specialization->id]);
            } else {
                if ($this->user->doctor) {
                    $this->user->doctor->delete();
                }
            }

            DB::commit();
            
            session()->flash('message', 'User updated successfully.');
            $this->reset();
            $this->redirectRoute('user-accounts.index');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->addError('updateError', 'An error occurred while updating the user.');
        }
    }

    public function close()
    {
        $this->reset();
    }

    public function render()
    {
        return view('livewire.edit-user-modal');
    }
}
