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
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public bool $showModal = false;
    public ?Patient $patient = null;
    public EditPatientForm $form;

    #[Validate('image', message: 'Invalid file type. Only image files are allowed.')]
    #[Validate('max:1024', message: 'File size too large. Max size allowed is 1MB.')]
    public mixed $new_profile_photo = null;

    public function mount($patient_id): void
    {
        $this->patient = Patient::find($patient_id);

        $patient_data = $this->patient->toArray();

        if ($patient_data['middle_name'] == null) {
            $patient_data['middle_name'] = '';
        }

        if ($patient_data['profile_photo_path'] == null) {
            $patient_data['profile_photo_path'] = '';
        }

        $this->form->fill($patient_data);

        if(isset($this->patient->address)) {
            $this->form->house_number = '';
            $this->form->street = '';
            $this->form->barangay = '';
            $this->form->city = '';
            $this->form->province = '';
            $this->form->country = '';
        }

        if (isset($this->patient->parents)) {
            $mother = $this->patient->parents->where('pivot.relationship', 'mother')->first();

            // Check if mother record exists before accessing properties
            if ($mother) {
                $this->form->mother_id = $mother->id;
                $this->form->mother_first_name = $mother->first_name;
                $this->form->mother_middle_name = $mother->middle_name;
                $this->form->mother_last_name = $mother->last_name;
                $this->form->mother_philhealth = $mother->philhealth_no;
            }

            $mother = $this->patient->parents->where('pivot.relationship', 'mother')->first();

            // Check if mother record exists before accessing properties
            if ($mother) {
                $this->form->mother_id = $mother->id;
                $this->form->mother_first_name = $mother->first_name;
                $this->form->mother_middle_name = $mother->middle_name;
                $this->form->mother_last_name = $mother->last_name;
                $this->form->mother_philhealth = $mother->philhealth_no;
            }

            $father = $this->patient->parents->where('pivot.relationship', 'father')->first();

            // Check if father record exists before accessing properties
            if ($father) {
                $this->form->father_id = $father->id;
                $this->form->father_first_name = $father->first_name;
                $this->form->father_middle_name = $father->middle_name;
                $this->form->father_last_name = $father->last_name;
                $this->form->father_philhealth = $father->philhealth_no;
            }
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

    public function save(UpdatePatientInformation $updater): void
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
                "User " . auth()->user()->username . " updated patient information for patient " . $this->patient->full_name . ".",
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
                "User " . auth()->user()->username . " failed to update patient information for patient " . $this->patient->full_name . ".",
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
