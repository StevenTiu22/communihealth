<?php

namespace App\Livewire\Schedules;

use App\Events\UserActivityEvent;
use App\Models\Appointment;
use App\Models\Disease;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;

class AddTreatmentRecord extends Component
{
    public bool $showModal = false;
    public ?int $appointment_id = null;

    #[Validate('required', message: 'Please select a disease')]
    #[Validate('exists:diseases,id', message: 'The selected disease does not exist')]
    public ?int $disease_id = null;

    #[Validate('required', message: 'Assessment is required')]
    #[Validate('string', message: 'Assessment must be text')]
    #[Validate('max:16777215', message: 'Assessment is too long')]
    public ?string $assessment = null;

    #[Validate('required', message: 'Diagnosis is required')]
    #[Validate('string', message: 'Diagnosis must be text')]
    #[Validate('max:16777215', message: 'Diagnosis is too long')]
    public ?string $diagnosis = null;

    #[Validate('nullable', message: 'Treatment is optional')]
    #[Validate('string', message: 'Treatment must be text')]
    #[Validate('max:16777215', message: 'Treatment is too long')]
    public ?string $treatment = null;

    #[Validate('nullable', message: 'Medication is optional')]
    #[Validate('string', message: 'Medication must be text')]
    #[Validate('max:16777215', message: 'Medication is too long')]
    public ?string $medication = null;

    public function mount(int $appointment_id): void
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
            $appointment = Appointment::findOrFail($this->appointment_id);

            $appointment->treatment_record->create([
                'disease_id' => $this->disease_id,
                'assessment' => $this->assessment,
                'diagnosis' => $this->diagnosis,
                'treatment' => $this->treatment,
                'medication' => $this->medication,
            ]);

            event(new UserActivityEvent(
                auth()->user(),
                'Successfully added treatment record',
                'Doctor ' . auth()->user()->username . ' added a treatment record for appointment ' . $this->appointment_id,
                [
                    'appointment_id' => $this->appointment_id,
                    'disease_id' => $this->disease_id,
                    'assessment' => $this->assessment,
                    'diagnosis' => $this->diagnosis,
                    'treatment' => $this->treatment,
                    'medication' => $this->medication,
                ],
                Carbon::now()->toDateTimeString()
            ));

            session()->flash('success', 'Treatment record added successfully.');

            $this->redirect(route('schedules.index'));
        } catch (\Exception $e) {
            event(new UserActivityEvent(
                auth()->user(),
                'Failed to add treatment record',
                'Doctor ' . auth()->user()->username . ' failed to add a treatment record for appointment ' . $this->appointment_id,
                [
                    'appointment_id' => $this->appointment_id,
                    'disease_id' => $this->disease_id,
                    'assessment' => $this->assessment,
                    'diagnosis' => $this->diagnosis,
                    'treatment' => $this->treatment,
                    'medication' => $this->medication,
                    'error' => $e->getMessage(),
                ],
                Carbon::now()->toDateTimeString()
            ));

            session()->flash('error', 'Failed to add treatment record: ' . $e->getMessage());

            $this->redirect(route('schedules.index'));
        }
    }

    public function render(): View
    {
        $diseases = Disease::all()->orderBy('name', 'asc');

        return view('livewire.schedules.add-treatment-record', [
            'diseases' => $diseases,
        ]);
    }
}
