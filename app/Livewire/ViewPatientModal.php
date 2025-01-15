<?php

namespace App\Livewire;

use Livewire\Component;

class ViewPatientModal extends Component
{
    public $showModal = false;
    public $patient;
    public $profile_photo;
    public $first_name;
    public $middle_name;
    public $last_name;
    public $gender;
    public $birth_date;
    public $contact_number;
    public $is_4ps;
    public $is_NHTS;
    public $house_number;
    public $street;
    public $barangay;
    public $city;
    public $mother_first_name;  
    public $mother_middle_name;
    public $mother_last_name;
    public $mother_philhealth;
    public $father_first_name;
    public $father_middle_name;
    public $father_last_name;
    public $father_philhealth;

    public function mount($patient)
    {
        $this->patient = $patient;
        $this->profile_photo = $patient->profile_photo_path;
        $this->first_name = $patient->first_name;
        $this->middle_name = $patient->middle_name;
        $this->last_name = $patient->last_name;
        $this->gender = $patient->gender;
        $this->birth_date = $patient->birth_date;
        $this->contact_number = $patient->contact_number;
        $this->is_4ps = $patient->is_4ps;
        $this->is_NHTS = $patient->is_NHTS;

        $address = $patient->addresses()->first();

        $this->house_number = $address->house_number;
        $this->street = $address->street;
        $this->barangay = $address->barangay;
        $this->city = $address->city;

        $mother = $patient->parents()->where('status', 'Mother')->first();
        if ($mother) {
            $this->mother_first_name = $mother->first_name;
            $this->mother_middle_name = $mother->middle_name;
            $this->mother_last_name = $mother->last_name;
            $this->mother_philhealth = $mother->philhealth_no;
        }

        $father = $patient->parents()->where('status', 'Father')->first();
        if ($father) {
            $this->father_first_name = $father->first_name;
            $this->father_middle_name = $father->middle_name;
            $this->father_last_name = $father->last_name;
            $this->father_philhealth = $father->philhealth_no;
        }
    }

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal() 
    {
        $this->showModal = false;
    }

    public function render()
    {
        return view('livewire.view-patient-modal');
    }
}