<?php

namespace App\Livewire\Schedules;

use App\Models\Appointment;
use Livewire\Component;

class ScheduleDropdown extends Component
{
    public $selectedAppointment;
    public $appointments;
    public $schedules;
    public $patientId;

    public function mount($patientId = null)
    {
        $this->patientId = $patientId;
        $this->loadAppointments();
    }

    public function loadAppointments()
    {
        $this->appointments = Appointment::where('patient_id', $this->patientId)
            ->with('schedules')
            ->get();
    }

    public function updatedSelectedSchedule()
    {
        $this->dispatch('appointment-selected', schedule: $this->selectedSchedule);
    }

    public function render()
    {
        return view('livewire.schedule-dropdown');
    }
}
