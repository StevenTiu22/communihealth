<?php

namespace App\Livewire\Schedules;

use App\Events\UserActivityEvent;
use App\Models\Appointment;
use App\Models\AppointmentQueue;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Complete extends Component
{
    public bool $showModal = false;

    public ?int $appointment_queue_id = null;
    public ?int $vital_sign_id = null;
    public ?int $treatment_record_id = null;


    public function mount($appointment_queue_id): void
    {
        $appointment_queue_id = $this->appointment_queue_id;
        $appointment_queue = AppointmentQueue::findOrFail($appointment_queue_id);

        $this->vital_sign_id = $appointment_queue->appointment->vitalSign->id;
        $this->treatment_record_id = $appointment_queue->appointment->treatmentRecord->id;
    }

    public function open(): void
    {
        $this->showModal = true;
    }

    public function close(): void
    {
        $this->showModal = false;
    }

    public function save(): void
    {
        $appointment_queue = AppointmentQueue::findOrFail($this->appointment_queue_id);

        if (! empty($this->vital_sign_id) && ! empty($this->treatment_record_id)) {
            try {

                $appointment_queue->update([
                    'queue_status' => 'completed',
                ]);

                $appointment_queue->appointment->update([
                    'completed_at' => Carbon::now('UTC'),
                ]);

                event(new UserActivityEvent(
                    auth()->user(),
                    'Completed appointment for patient: ' . $appointment_queue->appointment->patient->full_name,
                    'Doctor ' . auth()->user()->username . ' completed the appointment for patient: ' . $appointment_queue->appointment->patient->full_name,
                    [
                        'appointment_id' => $this->appointment_queue_id,
                        'doctor_id' => $appointment_queue->appointment->doctor_id,
                    ],
                    Carbon::now()->toDateTimeString(),
                ));

                session()->flash('success', 'Appointment completed successfully.');

                $this->redirectRoute('schedules.index');
            } catch (\Exception $e) {
                event(new UserActivityEvent(
                    auth()->user(),
                    'Failed to complete appointment for patient: ' . $appointment_queue->appointment->patient->full_name,
                    'Doctor ' . auth()->user()->username . ' failed to complete the appointment for patient: ' . $appointment_queue->appointment->patient->full_name,
                    [
                        'appointment_id' => $this->appointment_queue_id,
                        'doctor_id' => $appointment_queue->appointment->doctor_id,
                    ],
                    Carbon::now()->toDateTimeString(),
                ));

                session()->flash('error', 'Failed to complete the appointment. Please try again.');

                $this->redirect(route('schedules.index'));
            }
        } else {
            session()->flash('error', 'Please complete the vital signs and treatment record before completing the appointment.');

            $this->redirectRoute('schedules.index');
        }
    }

    public function render(): View
    {
        return view('livewire.schedules.complete');
    }
}
