<?php

namespace App\Livewire\HealthRecords;

use App\Events\UserActivityEvent;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class EditVitalSign extends Component
{
    public bool $showModal = false;

    public Appointment $appointment;

    #[Validate('required', message: 'Weight is required')]
    #[Validate('numeric', message: 'Weight must be a number')]
    #[Validate('min:0', message: 'Weight must be a positive number')]
    public ?float $weight = null;

    #[Validate('required', message: 'Height is required')]
    #[Validate('numeric', message: 'Height must be a number')]
    #[Validate('min:0', message: 'Height must be a positive number')]
    public ?float $height = null;

    #[Validate('required', message: 'Diastolic pressure is required')]
    #[Validate('integer', message: 'Diastolic pressure must be a whole number')]
    #[Validate('min:0', message: 'Diastolic pressure must be a positive number')]
    public ?int $diastolic = null;

    #[Validate('required', message: 'Systolic pressure is required')]
    #[Validate('integer', message: 'Systolic pressure must be a whole number')]
    #[Validate('min:0', message: 'Systolic pressure must be a positive number')]
    public ?int $systolic = null;

    #[Validate('required', message: 'Temperature is required')]
    #[Validate('numeric', message: 'Temperature must be a number')]
    #[Validate('min:0', message: 'Temperature must be a positive number')]
    public ?float $temperature = null;

    #[On('health-records-edit-vital-sign-open')]
    public function open($appointment_id): void
    {
        $this->showModal = true;
        $this->appointment = Appointment::findOrFail($appointment_id);
        $this->weight = $this->appointment->vitalSign->weight;
        $this->height = $this->appointment->vitalSign->height;
        $this->diastolic = $this->appointment->vitalSign->diastolic;
        $this->systolic = $this->appointment->vitalSign->systolic;
        $this->temperature = $this->appointment->vitalSign->temperature;
    }

    public function close(): void
    {
        $this->showModal = false;
        $this->reset(['weight', 'height', 'diastolic', 'systolic', 'temperature']);
    }

    public function save(): void
    {
        $this->validate();

        try {
            $this->appointment->vitalSign->update([
                'weight' => $this->weight,
                'height' => $this->height,
                'diastolic' => $this->diastolic,
                'systolic' => $this->systolic,
                'temperature' => $this->temperature,
            ]);

            event(new UserActivityEvent(
                auth()->user(),
                "Updated vital signs record",
                "BHW " . auth()->user()->last_name . " updated vital signs record for patient " . $this->appointment->patient->full_name . " on " . now()->addHours(8)->format('Y-m-d H:i:s'),
                [
                    'appointment_id' => $this->appointment->id,
                    'patient_id' => $this->appointment->patient->id,
                    'vital_signs_id' => $this->appointment->vitalSign->id,
                ],
                Carbon::now()->toDateTimeString()
            ));

            session()->flash('success', 'Vital signs updated successfully.');

            $this->redirect(route('health-records.index'));
        } catch (\Exception $e) {
            event(new UserActivityEvent(
                auth()->user(),
                "Failed to update vital signs record",
                "BHW " . auth()->user()->last_name . " failed to update vital signs record for patient " . $this->appointment->patient->full_name . " on " . now()->addHours(8)->format('Y-m-d H:i:s'),
                [
                    'appointment_id' => $this->appointment->id,
                    'patient_id' => $this->appointment->patient->id,
                    'vital_signs_id' => $this->appointment->vitalSign->id,
                ],
                Carbon::now()->toDateTimeString()
            ));

            session()->flash('error', 'Failed to update vital signs. Please try again.');

            $this->redirect(route('health-records.index'));
        }
    }

    public function render(): View
    {
        return view('livewire.health-records.edit-vital-sign');
    }
}
