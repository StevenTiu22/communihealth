<?php

namespace App\Livewire\Schedules;

use App\Models\Appointment;
use Livewire\Component;

class AppointmentCheckInOut extends Component
{
    public Appointment $appointment;
    public $schedule;

    public function mount(Appointment $appointment)
    {
        $this->appointment = $appointment;
        $this->schedule = $appointment->schedule;
    }

    public function checkIn()
    {
        if (!$this->schedule) {
            return;
        }

        $this->schedule->update([
            'time_in' => now(),
        ]);

        $this->appointment->update(['status' => 'in_progress']);
    }

    public function checkOut()
    {
        if (!$this->schedule || !$this->schedule->time_in) {
            return;
        }

        $this->schedule->update([
            'time_out' => now()
        ]);

        $this->appointment->update(['status' => 'completed']);
    }

    public function render()
    {
        return view('livewire.appointment-check-in-out');
    }
}
