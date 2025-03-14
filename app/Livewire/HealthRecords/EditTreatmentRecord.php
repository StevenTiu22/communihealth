<?php

namespace App\Livewire\HealthRecords;

use App\Events\UserActivityEvent;
use App\Models\Appointment;
use App\Models\Disease;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class EditTreatmentRecord extends Component
{
    public bool $showModal = false;
    public Appointment $appointment;

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

    #[On('health-records-edit-treatment-record-open')]
    public function open($appointment_id): void
    {
        $this->showModal = true;
        $this->appointment = Appointment::findOrFail($appointment_id);

        if ($this->appointment->treatmentRecord->disease != null) {
            $this->disease_id = $this->appointment->treatmentRecord->disease->id;
        }

        $this->assessment = $this->appointment->treatmentRecord->assessment;
        $this->diagnosis = $this->appointment->treatmentRecord->diagnosis;
        $this->treatment = $this->appointment->treatmentRecord->treatment;
        $this->medication = $this->appointment->treatmentRecord->medication;
    }

    public function close(): void
    {
        $this->showModal = false;
        $this->reset(['disease_id', 'assessment', 'diagnosis', 'treatment', 'medication']);
    }

    public function save(): void
    {
        $this->validate();

        try {
            $this->appointment->treatmentRecord->update([
                'disease_id' => $this->disease_id,
                'assessment' => $this->assessment,
                'diagnosis' => $this->diagnosis,
                'treatment' => $this->treatment,
                'medication' => $this->medication,
            ]);

            event(new UserActivityEvent(
               auth()->user(),
               'Updated treatment record',
               'Doctor ' . auth()->user()->last_name . ' updated treatment record for patient ' . $this->appointment->patient->full_name . ' on ' . now()->addHours(8)->format('Y-m-d H:i:s'),
               [
                   'appointment_id' => $this->appointment->id,
                   'patient_id' => $this->appointment->patient->id,
                   'treatment_record_id' => $this->appointment->treatmentRecord->id,
               ],
                Carbon::now()->format('Y-m-d H:i:s')
            ));

            session()->flash('success', 'Treatment record updated successfully.');
            $this->redirect(route('health-records.index'));
        } catch (\Exception $e) {
            event(new UserActivityEvent(
                auth()->user(),
                'Failed to update treatment record',
                'Doctor ' . auth()->user()->last_name . ' failed to update treatment record for patient ' . $this->appointment->patient->full_name . ' on ' . now()->addHours(8)->format('Y-m-d H:i:s'),
                [
                    'appointment_id' => $this->appointment->id,
                    'patient_id' => $this->appointment->patient->id,
                    'treatment_record_id' => $this->appointment->treatmentRecord->id,
                ],
                Carbon::now()->toDateTimeString()
            ));

            session()->flash('error', 'Failed to update treatment record. Please try again.');

            $this->redirect(route('health-records.index'));
        }
    }

    public function render(): View
    {
        $diseases = Disease::orderBy('name')->get();

        return view('livewire.health-records.edit-treatment-record', [
            'diseases' => $diseases,
        ]);
    }
}
