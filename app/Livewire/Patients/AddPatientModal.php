<?php

namespace App\Livewire\Patients;

use Livewire\Component;

class AddPatientModal extends Component
{
    public $isOpen = false;
    public $patient = [
        'first_name' => '',
        'last_name' => '',
        'date_of_birth' => '',
        'gender' => '',
        'contact_number' => '',
        'email' => '',
        'address' => '',
    ];

    protected $rules = [
        'patient.first_name' => 'required|min:2',
        'patient.last_name' => 'required|min:2',
        'patient.date_of_birth' => 'required|date',
        'patient.gender' => 'required|in:male,female,other',
        'patient.contact_number' => 'required',
        'patient.email' => 'nullable|email',
        'patient.address' => 'required',
    ];

    public function save()
    {
        $this->validate();
        Patient::create($this->patient);
        $this->emit('patientAdded');
        $this->close();
    }

    public function close()
    {
        $this->isOpen = false;
        $this->reset('patient');
    }

    public function render()
    {
        return view('livewire.patients.add-patient-modal');
    }
} 