<?php

namespace App\Livewire\Schedules;

use App\Models\Patient;
use App\Models\User;
use Livewire\Component;

class AssignDoctorModal extends Component
{
    public $showModal = false;
    public $patient;
    public $selectedDoctor;
    public $selectedDate;
    public $selectedTime;

    public function mount(Patient $patient)
    {
        $this->patient = $patient;
    }

    public function assignDoctor()
    {
        $this->validate([
            'selectedDoctor' => 'required',
            'selectedDate' => 'required|date|after_or_equal:today',
            'selectedTime' => 'required'
        ]);

        $this->patient->update([
            'doctor_id' => $this->selectedDoctor,
            'appointment_date' => $this->selectedDate,
            'appointment_time' => $this->selectedTime
        ]);

        $this->closeModal();
        $this->dispatch('doctor-assigned');
        session()->flash('success', 'Doctor assigned successfully.');
    }

    public function render()
    {
        $doctors = User::where('role', 'doctor')->get();

        return view('livewire.assign-doctor-modal', [
            'doctors' => $doctors
        ]);
    }
}
