<?php

namespace App\Livewire\Schedules;

use App\Models\AppointmentQueue;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class InProgressTable extends Component
{
    public string $search = '';
    public int $doctor_id = 0;
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
            ->where('queue_status', 'in_progress')
            ->with(['appointment.patient', 'appointment.appointmentType', 'appointment.doctor']);

        if (! empty($this->search)) {
            $appointment_queues->whereHas('appointment.patient', function ($query) {
                $query->where('first_name', 'like', '%' . $this->search . '%')
                    ->orWhere('middle_name', 'like', '%' . $this->search . '%')
                    ->orWhere('last_name', 'like', '%' . $this->search . '%');
            })
            ->orWhereHas('appointment.appointment_type', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orWhereHas('appointment.doctor.user', function ($query) {;
                $query->where('first_name', 'like', '%' . $this->search . '%')
                    ->orWhere('middle_name', 'like', '%' . $this->search . '%')
                    ->orWhere('last_name', 'like', '%' . $this->search . '%');
            });
        }

        $appointment_queues->orderBy('called_at', 'desc')->get();

        return view('livewire.schedules.in-progress-table', [
            'appointment_queues' => $appointment_queues
        ]);
    }
}
