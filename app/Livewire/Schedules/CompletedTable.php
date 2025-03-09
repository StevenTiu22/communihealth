<?php

namespace App\Livewire\Schedules;

use App\Models\AppointmentQueue;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class CompletedTable extends Component
{
    public string $search = '';
    public string $doctor_id = '';

    public function updatedSearch($search): void
    {
        $this->search = $search;
    }

    public function updatedDoctorId($doctor_id): void
    {
        $this->doctor_id = $doctor_id;
    }

    public function render(): View
    {
        $appointment_queues = AppointmentQueue::query()
            ->where('queue_status', 'completed')
            ->with(['appointment.patient', 'appointment.appointmentType', 'appointment.doctor']);

        if (! empty($this->search)) {

        }

        return view('livewire.schedules.completed-table');
    }
}
