<?php

namespace App\Livewire\Schedules;

use App\Events\UserActivityEvent;
use App\Models\Appointment;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CancelAppointment extends Component
{
    public bool $showModal = false;

    public Appointment $appointment;

    #[Validate('required', message: 'The reason for cancellation is required')]
    #[Validate('string', message: 'The reason for cancellation must be a string')]
    public string $reason = '';

    public function mount($appointment_id): void
    {
        $this->appointment = Appointment::findOrFail($appointment_id);
    }

    public function open(): void
    {
        $this->showModal = true;
    }

    public function close(): void
    {
        $this->showModal = false;
    }

    public function cancel(): void
    {
        $this->validate();

        try {
            $this->appointment->update([
                'is_cancelled' => 1,
                'cancellation_reason' => $this->reason,
            ]);

            $this->appointment->appointment_queue->update([
                'queue_number' => 0,
                'queue_status' => 'cancelled',
            ]);

            event(new UserActivityEvent(
                auth()->user(),
                'Cancelled appointment',
                'BHW user ' . auth()->user()->username . ' cancelled appointment for patient ' . $this->appointment->patient->full_name . ' on ' . now()->format('Y-m-d H:i:s'),
                [
                    'appointment_id' => $this->appointment->id,
                    'bhw_id' => auth()->id,
                    'patient_id' => $this->appointment->patient->id,
                    'cancellation_reason' => $this->reason,
                ],
                Carbon::now()->toDateTimeString(),
            ));

            session()->flash('success', 'Appointment cancelled successfully.');

            $this->redirect(route('schedules.index'));
        } catch (Exception $e) {
            event(new UserActivityEvent(
                auth()->user(),
                'Failed to cancel appointment',
                'BHW user ' . auth()->user()->username . ' failed to cancel appointment for patient ' . $this->appointment->patient->full_name . ' on ' . now()->format('Y-m-d H:i:s'),
                [
                    'appointment_id' => $this->appointment->id,
                    'bhw_id' => auth()->id,
                    'patient_id' => $this->appointment->patient->id,
                    'error_message' => $e->getMessage(),
                ],
                Carbon::now()->toDateTimeString(),
            ));

            session()->flash('error', 'Failed to cancel appointment: ' . $e->getMessage());

            $this->redirect(route('schedules.index'));
        }
    }

    public function render(): View
    {
        return view('livewire.schedules.cancel-appointment');
    }
}
