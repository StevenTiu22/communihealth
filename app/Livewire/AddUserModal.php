<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Address;
use App\Models\ParentInfo;
use App\Models\Specialization;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;

class AddUserModal extends Component
{
    use WithFileUploads;

    public $role = -1;
    public $profile_photo;
    public $first_name = '';
    public $middle_name = '';
    public $last_name = '';
    public $birth_date = '';
    public $gender = '';
    public $father_first_name = '';
    public $father_middle_name = '';
    public $father_last_name = '';
    public $father_philhealth = '';
    public $mother_first_name = '';
    public $mother_middle_name = '';
    public $mother_last_name = '';
    public $mother_philhealth = '';
    public $password = '';
    public $password_confirmation = '';
    public $house_number = '';
    public $street = '';
    public $barangay = '';
    public $city = '';
    public $license_number = '';
    public $specialization = '';
    public $local_government_unit = '';
    public $issuance_date = '';
    public $position = '';
    public $term_start = '';
    public $term_end = '';

    protected function rules()
    {
        return [
            'first_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s\.]+$/'],
            'middle_name' => ['nullable', 'string', 'max:255', 'regex:/^[a-zA-Z\s\.]+$/'],
            'last_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s\.]+$/'],
            'birth_date' => ['required', 'date', 'before:today'],
            'gender' => ['required', 'in:0,1'],
            'father_first_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s\.]+$/'],
            'father_middle_name' => ['nullable', 'string', 'max:255', 'regex:/^[a-zA-Z\s\.]+$/'],
            'father_last_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s\.]+$/'],
            'father_philhealth' => ['required', 'string', 'digits:12'],
            'mother_first_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s\.]+$/'],
            'mother_middle_name' => ['nullable', 'string', 'max:255', 'regex:/^[a-zA-Z\s\.]+$/'],
            'mother_last_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s\.]+$/'],
            'mother_philhealth' => ['required', 'string', 'digits:12'],
            'password' => ['required', 'string', 'min:8', 'regex:/^\S*$/'],
            'password_confirmation' => ['required_with:password', 'same:password'],
            'role' => ['required', 'in:0,1,2,3'],
            'profile_photo' => ['nullable', 'image', 'max:1024'],
            'house_number' => ['required', 'string', 'max:50'],
            'street' => ['required', 'string', 'max:255'],
            'barangay' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'license_number' => ['required_if:role,2', 'string', 'max:50'],
            'specialization' => ['required_if:role,2', 'string', 'max:100'],
            'local_government_unit' => ['required_if:role,1', 'string', 'max:255'],
            'issuance_date' => ['required_if:role,1', 'date', 'before_or_equal:today'],
            'position' => ['required_if:role,0', 'string', 'max:255'],
            'term_start' => ['required_if:role,0', 'date'],
            'term_end' => ['required_if:role,0', 'date', 'after:term_start', 'after:today'],
        ];
    }

    protected function messages()
    {
        return [
            'first_name.required' => 'Please enter your first name.',
            'first_name.regex' => 'First name can only contain letters, spaces and dots.',
            'middle_name.regex' => 'Middle name can only contain letters, spaces and dots.',
            'last_name.required' => 'Please enter your last name.',
            'last_name.regex' => 'Last name can only contain letters, spaces and dots.',
            'birth_date.required' => 'Please enter your birth date.',
            'birth_date.before' => 'Birth date must be a date before today.',
            'gender.required' => 'Please select your gender.',
            'gender.in' => 'Please select a valid gender.',
            'father_first_name.required' => 'Please enter father\'s first name.',
            'father_first_name.regex' => 'Father\'s first name can only contain letters, spaces and dots.',
            'father_middle_name.regex' => 'Father\'s middle name can only contain letters, spaces and dots.',
            'father_last_name.required' => 'Please enter father\'s last name.',
            'father_last_name.regex' => 'Father\'s last name can only contain letters, spaces and dots.',
            'father_philhealth.required' => 'Please enter father\'s PhilHealth number.',
            'father_philhealth.size' => 'PhilHealth number must be 12 digits.',
            'mother_first_name.required' => 'Please enter mother\'s first name.',
            'mother_first_name.regex' => 'Mother\'s first name can only contain letters, spaces and dots.',
            'mother_middle_name.regex' => 'Mother\'s middle name can only contain letters, spaces and dots.',
            'mother_last_name.required' => 'Please enter mother\'s last name.',
            'mother_last_name.regex' => 'Mother\'s last name can only contain letters, spaces and dots.',
            'mother_philhealth.required' => 'Please enter mother\'s PhilHealth number.',
            'mother_philhealth.size' => 'PhilHealth number must be 12 digits.',
            'password.required' => 'Please enter a password.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.regex' => 'Password cannot contain spaces.',
            'password_confirmation.same' => 'The password confirmation does not match.',
            'password_confirmation.required_with' => 'Please confirm your password.',
            'role.required' => 'Please select a role.',
            'role.in' => 'Please select a valid role.',
            'profile_photo.image' => 'The file must be an image.',
            'profile_photo.max' => 'The image must not be larger than 1MB.',
            'house_number.required' => 'Please enter your house number.',
            'street.required' => 'Please enter your street.',
            'barangay.required' => 'Please enter your barangay.',
            'city.required' => 'Please enter your city.',
            'license_number.required_if' => 'Please enter your license number.',
            'specialization.required_if' => 'Please enter your specialization.',
            'local_government_unit.required_if' => 'Please enter the Local Government Unit.',
            'issuance_date.required_if' => 'Please enter the issuance date.',
            'issuance_date.before_or_equal' => 'Issuance date cannot be in the future.',
            'position.required_if' => 'Please select a position.',
            'term_start.required_if' => 'Please enter the term start date.',
            'term_end.required_if' => 'Please enter the term end date.',
            'term_end.after' => 'Term end date must be after term start date and today.'
        ];
    }


    public $showModal = false;

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset();
    }

    public function updated($propertyName)
    {
        

        $this->validateOnly($propertyName, $this->rules(), $this->messages());
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

    public function render()
    {
        return view('livewire.add-user-modal');
    }
}
