<?php

namespace App\Livewire\Schedules;

use App\Events\UserActivityEvent;
use App\Models\Appointment;
use App\Models\AppointmentQueue;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;

class WaitingTable extends Component
{
    public string $search = '';
    public string $doctor_id = '';

    #[On('schedules-search-updated')]
    public function updatedSearch($search): void
    {
        $this->search = $search;
    }

    public function updatedDoctorId($doctor_id): void
    {
        $this->doctor_id = $doctor_id;
    }

    public function start($appointment_queue_id): void
    {
        try {
            $appointment_queue = AppointmentQueue::find($appointment_queue_id);

            $appointment_queue->update([
                'queue_status' => 'in progress',
            ]);

            event(new UserActivityEvent(
                auth()->user(),
                "Started an appointment queue",
                "BHW " . auth()->user()->last_name . " started an appointment queue for " . $appointment_queue->appointment->patient->full_name . " (" . $appointment_queue->queue_number . ")",
                [
                    'appointment_queue_id' => $appointment_queue->id,
                    'appointment_id' => $appointment_queue->appointment->id,
                    'queue_number' => $appointment_queue->queue_number,
                    'queue_status' => $appointment_queue->queue_status,
                ],
                Carbon::now()->toDateTimeString()
            ));

            session()->flash('message', 'Appointment queue started successfully.');

            $this->redirect(route('schedules.index'));
        } catch(\Exception $e) {
            event(new UserActivityEvent(
                auth()->user(),
                "Failed to start an appointment queue",
                "BHW " . auth()->user()->last_name . " failed to start an appointment queue for " . $appointment_queue->appointment->patient->full_name . " (" . $appointment_queue->queue_number . ")",
                [
                    'appointment_queue_id' => $appointment_queue->id,
                    'appointment_id' => $appointment_queue->appointment->id,
                    'queue_number' => $appointment_queue->queue_number,
                    'queue_status' => $appointment_queue->queue_status,
                ],
                Carbon::now()->toDateTimeString()
            ));

            session()->flash('error', 'Failed to start appointment queue. Please try again later.');

            // Optionally, you can log the error message for debugging
            Log::error('Error starting appointment queue: ' . $e->getMessage());

            $this->redirect(route('schedules.index'));
        }
    }

    public function render(): View
    {
        $appointment_queues = AppointmentQueue::query()
            ->where('queue_status', 'waiting')
            ->with(['appointment.patient', 'appointment.appointmentType', 'appointment.doctor']);

        if (! empty($this->search)) {
            $appointment_queues->whereHas('appointment.patient', function ($query) {
                $query->where('first_name', 'like', '%' . $this->search . '%')
                    ->orWhere('middle_name', 'like', '%' . $this->search . '%')
                    ->orWhere('last_name', 'like', '%' . $this->search . '%');
            });
        }

        if (! empty($this->doctor_id)) {
            $appointment_queues->whereHas('appointment.doctor', function ($query) {
                $query->where('user_id', $this->doctor_id);
            });
        }

        // Assign the collection to the variable
        $appointment_queues = $appointment_queues->orderBy('queue_number')->get();

        return view('livewire.schedules.waiting-table', [
            'appointment_queues' => $appointment_queues
        ]);
    }
}
