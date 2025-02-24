<?php

namespace App\Livewire\Patients;

use App\Events\UserActivityEvent;
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
    public mixed $new_profile_photo = null;

    public function mount($patient_id): void
    {
        $this->patient = Patient::find($patient_id);

        $this->form->fill($this->patient->toArray());

        $this->form->fill($this->address->toArray());

        if ($this->patient->parents) {
            // Add logic here
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
