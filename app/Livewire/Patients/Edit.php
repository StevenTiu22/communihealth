<?php

namespace App\Livewire\Patients;

use App\Actions\UpdatePatientInformation;
use App\Events\UserActivityEvent;
use App\Livewire\Forms\EditPatientForm;
use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Edit extends Component
{
    public bool $showModal = false;
    public ?Patient $patient = null;
    public EditPatientForm $form;

    #[Validate('image', message: 'Invalid file type. Only image files are allowed.')]
    #[Validate('max:1024', message: 'File size too large. Max size allowed is 1MB.')]
    public mixed $profile_photo = null;

    public function mount($patient_id): void
    {
        $this->patient = Patient::find($patient_id);

        $this->form->fill($this->patient->toArray());

        $this->form->fill($this->patient->address->toArray());

        if ($this->patient->parents->where('pivot.relationship', 'mother'))
        {
            $this->form->mother_id = $this->patient->parents->where('pivot.relationship', 'mother')->first()->id;
            $this->form->mother_first_name = $this->patient->parents->where('pivot.relationship', 'mother')->first()->first_name;
            $this->form->mother_middle_name = $this->patient->parents->where('pivot.relationship', 'mother')->first()->middle_name;
            $this->form->mother_last_name = $this->patient->parents->where('pivot.relationship', 'mother')->first()->last_name;
            $this->form->mother_philhealth = $this->patient->parents->where('pivot.relationship', 'mother')->first()->philhealth_no;
        }

        if ($this->patient->parents->where('pivot.relationship', 'father'))
        {
            $this->form->father_id = $this->patient->parents->where('pivot.relationship', 'father')->first()->id;
            $this->form->father_first_name = $this->patient->parents->where('pivot.relationship', 'father')->first()->first_name;
            $this->form->father_middle_name = $this->patient->parents->where('pivot.relationship', 'father')->first()->middle_name;
            $this->form->father_last_name = $this->patient->parents->where('pivot.relationship', 'father')->first()->last_name;
            $this->form->father_philhealth = $this->patient->parents->where('pivot.relationship', 'father')->first()->philhealth_no;
        }
    }

    public function open(): void
    {
        $this->showModal = true;
    }

    public function close(): void
    {
        $this->showModal = false;
        $this->form->resetErrorBag();
        $this->reset(['new_profile_photo']);
    }

    public function update(UpdatePatientInformation $updater): void
    {
        if ($this->new_profile_photo)
            $this->patient->updateProfilePhoto($this->new_profile_photo);

        $validated_data = $this->form->validate();

        try {
            $patient = $updater->update($this->patient, $validated_data);

            Log::info('Patient information updated successfully.');

            event(new UserActivityEvent(
                auth()->user(),
                'Updated patient information.',
                "User " . auth()->user()->name . " updated patient information for patient " . $this->patient->full_name . ".",
                [
                    'data' => $validated_data
                ],
                Carbon::now()->toDateTimeString()
            ));

            session()->flash('success', 'Patient information updated successfully.');
            $this->redirect(route('patients.index'));
        } catch (\Exception $e) {
            Log::error('Error updating patient information. Error: ' . $e->getMessage());

            event (new UserActivityEvent(
                auth()->user(),
                'Failed to update patient information.',
                "User " . auth()->user()->name . " failed to update patient information for patient " . $this->patient->full_name . ".",
                [
                    'data' => $validated_data,
                    'error' => $e->getMessage()
                ],
                Carbon::now()->toDateTimeString()
            ));

            session()->flash('error', 'Failed to update patient information.');
            $this->redirect(route('patients.index'));
        }
    }

    public function render(): View
    {
        return view('livewire.patients.edit');
    }
}
