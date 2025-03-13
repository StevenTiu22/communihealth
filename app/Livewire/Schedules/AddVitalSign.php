<?php

namespace App\Livewire\Schedules;

use App\Events\UserActivityEvent;
use App\Models\Appointment;
use App\Models\VitalSign;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;

class AddVitalSign extends Component
{
    public bool $showModal = false;

    public ?int $appointment_id = null;

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

    public function mount($appointment_id): void
    {
        $this->appointment_id = $appointment_id;
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
        $this->validate();

        try {
            $vital_sign = VitalSign::create([
                'weight' => $this->weight,
                'height' => $this->height,
                'diastolic' => $this->diastolic,
                'systolic' => $this->systolic,
                'temperature' => $this->temperature,
            ]);

            $appointment = Appointment::find($this->appointment_id);
            $appointment->vitalSign()->associate($vital_sign);
            $appointment->save();

            event(new UserActivityEvent(
                auth()->user(),
                'Added vital signs',
                'BHW user ' . auth()->user()->username . ' added vital signs for patient ' . $appointment->patient->full_name . ' on ' . now()->format('Y-m-d H:i:s'),
                [
                    'appointment_id' => $this->appointment_id,
                    'bhw_id' => auth()->user()->id,
                    'patient_id' => $appointment->patient->id,
                    'vital_signs' => [
                        'weight' => $this->weight,
                        'height' => $this->height,
                        'diastolic' => $this->diastolic,
                        'systolic' => $this->systolic,
                        'temperature' => $this->temperature,
                    ],
                ],
                Carbon::now()->toDateTimeString(),
            ));

            session()->flash('success', 'Vital signs added successfully.');

            $this->redirect(route('schedules.index'));
        } catch (Exception $e) {
            event(new UserActivityEvent(
                auth()->user(),
                'Failed to add vital signs',
                'BHW user ' . auth()->user()->username . ' failed to add vital signs for patient ' . $appointment->patient->full_name,
                [
                    'appointment_id' => $this->appointment_id,
                    'bhw_id' => auth()->id,
                    'patient_id' => $appointment->patient->id,
                    'error_message' => $e->getMessage(),
                ],
                Carbon::now()->toDateTimeString(),
            ));

            session()->flash('error', 'Failed to add vital signs: ' . $e->getMessage());

            $this->redirect(route('schedules.index'));
        }
    }

    public function render(): View
    {
        return view('livewire.schedules.add-vital-sign');
    }
}
