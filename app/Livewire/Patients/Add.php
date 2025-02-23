<?php

namespace App\Livewire\Patients;

use App\Models\Address;
use App\Models\ParentInfo;
use App\Models\Patient;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Add extends Component
{
    use WithFileUploads;

    public $showModal = false;

    public $first_name = '';
    public $middle_name = '';
    public $last_name = '';
    public $gender = '';
    public $birth_date = '';
    public $contact_number = '';
    public $is_4ps = false;
    public $is_NHTS = false;
    public $mother_first_name = '';
    public $mother_middle_name = '';
    public $mother_last_name = '';
    public $mother_philhealth = '';
    public $father_first_name = '';
    public $father_middle_name = '';
    public $father_last_name = '';
    public $father_philhealth = '';
    public $house_number = '';
    public $street = '';
    public $barangay = '';
    public $city = '';
    public $profile_photo = null;
    public $path = null;

    protected function rules()
    {
        return [
            'first_name' => 'required|string|regex:/^[a-zA-Z\s.-]*$/',
            'middle_name' => 'nullable|string|regex:/^[a-zA-Z\s.-]*$/',
            'last_name' => 'required|string|regex:/^[a-zA-Z\s.-]*$/',
            'gender' => 'required|numeric|in:0,1',
            'birth_date' => 'required|date|before:today',
            'contact_number' => 'required|numeric|digits:11',
            'is_4ps' => 'boolean',
            'is_NHTS' => 'boolean',
            'mother_first_name' => 'nullable|regex:/^[a-zA-Z\s.-]*$/',
            'mother_middle_name' => 'nullable|regex:/^[a-zA-Z\s.-]*$/',
            'mother_last_name' => 'nullable|regex:/^[a-zA-Z\s.-]*$/',
            'mother_philhealth' => 'nullable|regex:/^[0-9]{2}-[0-9]{9}-[0-9]$/',
            'father_first_name' => 'nullable|regex:/^[a-zA-Z\s.-]*$/',
            'father_middle_name' => 'nullable|regex:/^[a-zA-Z\s.-]*$/',
            'father_last_name' => 'nullable|regex:/^[a-zA-Z\s.-]*$/',
            'father_philhealth' => 'nullable|regex:/^[0-9]{2}-[0-9]{9}-[0-9]$/',
            'house_number' => 'required|string|max:50',
            'street' => 'required|string|max:100',
            'barangay' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'profile_photo' => 'nullable|image|max:1024'
        ];
    }

    protected function messages()
    {
        return [
            'first_name.required' => 'The first name field is required.',
            'first_name.regex' => 'The first name may only contain letters, spaces, dots and dashes.',
            'middle_name.regex' => 'The middle name may only contain letters, spaces, dots and dashes.',
            'last_name.required' => 'The last name field is required.',
            'last_name.regex' => 'The last name may only contain letters, spaces, dots and dashes.',
            'gender.required' => 'Please select a gender.',
            'gender.in' => 'Please select a valid gender.',
            'birth_date.required' => 'The birth date field is required.',
            'birth_date.before' => 'The birth date must be before today.',
            'birth_date.date' => 'Please enter a valid date.',
            'contact_number.required' => 'The contact number field is required.',
            'contact_number.digits' => 'The contact number must be exactly 11 digits.',
            'contact_number.numeric' => 'The contact number must contain only numbers.',
            'mother_first_name.regex' => 'The mother\'s first name may only contain letters, spaces, dots and dashes.',
            'mother_middle_name.regex' => 'The mother\'s middle name may only contain letters, spaces, dots and dashes.',
            'mother_last_name.regex' => 'The mother\'s last name may only contain letters, spaces, dots and dashes.',
            'mother_philhealth.regex' => 'The mother\'s PhilHealth number must be in XX-XXXXXXXXX-X format.',
            'father_first_name.regex' => 'The father\'s first name may only contain letters, spaces, dots and dashes.',
            'father_middle_name.regex' => 'The father\'s middle name may only contain letters, spaces, dots and dashes.',
            'father_last_name.regex' => 'The father\'s last name may only contain letters, spaces, dots and dashes.',
            'father_philhealth.regex' => 'The father\'s PhilHealth number must be in XX-XXXXXXXXX-X format.',
            'house_number.required' => 'The house number field is required.',
            'house_number.max' => 'The house number must not exceed 50 characters.',
            'street.required' => 'The street field is required.',
            'street.max' => 'The street must not exceed 100 characters.',
            'barangay.required' => 'The barangay field is required.',
            'barangay.max' => 'The barangay must not exceed 100 characters.',
            'city.required' => 'The city field is required.',
            'city.max' => 'The city must not exceed 100 characters.',
            'profile_photo.image' => 'The file must be an image.',
            'profile_photo.max' => 'The image must not be larger than 1MB.'
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, $this->rules(), $this->messages());
    }
    public function updatedProfilePhoto()
    {
        try {
            $this->validateOnly('profile_photo');
        } catch (\Exception $e) {
            $this->addError('profile_photo', 'Please upload a valid image file.');
            $this->profile_photo = null;
        }
    }

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->resetValidation();
        $this->reset();
        $this->showModal = false;
    }

    public function removePhoto()
    {
        $this->profile_photo = null;
    }

    public function render()
    {
        return view('livewire.patients.add');
    }

    public function save()
    {
        $this->validate();

        try {
            DB::beginTransaction();

            // Handle profile photo upload
            $this->path = $this->profile_photo ? $this->profile_photo->store('images', 'public') : 'images/default-avatar.png';

            $patient = Patient::firstOrCreate([
                'first_name' => $this->first_name,
                'middle_name' => $this->middle_name,
                'last_name' => $this->last_name,
                'gender' => $this->gender,
                'birth_date' => $this->birth_date,
                'contact_number' => $this->contact_number,
                'is_4ps' => $this->is_4ps,
                'is_NHTS' => $this->is_NHTS,
                'profile_photo_path' => $this->path
            ]);

            $address = Address::firstOrCreate([
                'house_number' => $this->house_number,
                'street' => $this->street,
                'barangay' => $this->barangay,
                'city' => $this->city
            ]);

            $patient->addresses()->attach($address->id);

            if ($this->mother_first_name || $this->mother_last_name) {
                $mother = ParentInfo::firstOrCreate([
                    'first_name' => $this->mother_first_name,
                    'middle_name' => $this->mother_middle_name,
                    'last_name' => $this->mother_last_name,
                    'philhealth_no' => $this->mother_philhealth,
                    'status' => 'Mother'
                ]);
                $patient->parents()->attach($mother->id);
            }

            if ($this->father_first_name || $this->father_last_name) {
                $father = ParentInfo::create([
                    'first_name' => $this->father_first_name,
                    'middle_name' => $this->father_middle_name,
                    'last_name' => $this->father_last_name,
                    'philhealth_no' => $this->father_philhealth,
                    'status' => 'Father'
                ]);
                $patient->parents()->attach($father->id);
            }

            DB::commit();

            session()->flash('success', 'Patient record created successfully.');
            $this->closeModal();
            $this->redirectRoute('patients.index');

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Failed to create patient record. Error: '.$e);
        }
    }
}
