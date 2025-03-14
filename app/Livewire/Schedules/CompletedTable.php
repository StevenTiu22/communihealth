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
            ->with(['appointment', 'appointment.patient', 'appointment.doctor', 'appointment.appointmentType']);

        if (! empty($this->search)) {
            $appointment_queues->whereHas('appointment.patient', function ($query) {
                $query->where('first_name', 'like', '%' . $this->search . '%')
                    ->orWhere('middle_name', 'like', '%' . $this->search . '%')
                    ->orWhere('last_name', 'like', '%' . $this->search . '%');
            });
        }

        if (! empty($this->doctor_id)) {
            $appointment_queues->whereHas('appointment.doctor', function ($query) {
                $query->where('doctor_id', $this->doctor_id);
            });
        }

        $appointment_queues = $appointment_queues->orderBy('queue_number')->get();

        return view('livewire.schedules.completed-table', [
            'appointment_queues' => $appointment_queues
        ]);
    }
}
