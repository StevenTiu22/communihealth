<?php

namespace App\Livewire\Patients;

use App\Actions\CreatePatientInformation;
use App\Events\UserActivityEvent;
use App\Livewire\Forms\CreatePatientForm;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Add extends Component
{
    use WithFileUploads;

    public bool $showModal = false;
    public CreatePatientForm $form;

    #[Validate('image', message: 'Invalid file type. Only image files are allowed.')]
    #[Validate('max:1024', message: 'File size too large. Max size allowed is 1MB.')]
    public mixed $profile_photo = null;

    public function open(): void
    {
        $this->showModal = true;
    }

    public function close(): void
    {
        $this->resetValidation();
        $this->reset();
        $this->showModal = false;
    }

    public function removePhoto(): void
    {
        $this->profile_photo = null;
    }

    public function save(CreatePatientInformation $creator): void
    {
        // Profile photo handling
        if ($this->profile_photo)
            $this->form->profile_photo_path = $this->profile_photo->store('images', 'public');
        else
            $this->form->profile_photo_path = 'images/default-avatar.png';

        // Validating form data
        $validated_data = $this->form->validate();

        try {
            $patient = $creator->create($validated_data);

            event(new UserActivityEvent(
                auth()->user(),
                'Added patient.',
                "User {auth()->user()->name} added patient $patient->full_name.",
                [
                    'data' => $validated_data,
                ],
                Carbon::now()->toDateTimeString()
            ));

            session()->flash('success', 'Patient added successfully.');
            $this->redirect(route('patients.index'));
        } catch (Exception $e) {
            Log::error("Error adding patient. Error: " . $e->getMessage());

            event(new UserActivityEvent(
                auth()->user(),
                'Failed to add patient.',
                "User {auth()->user()->name} failed to add patient. Error: " . $e->getMessage(),
                [
                    'error' => $e->getMessage(),
                    'validated_data' => $validated_data,
                ],
                Carbon::now()->toDateTimeString()
            ));

            session()->flash('error', 'Failed to add patient.');
            $this->redirect(route('patients.index'));
        }
    }

    public function render(): View
    {
        return view('livewire.patients.add');
    }
}
