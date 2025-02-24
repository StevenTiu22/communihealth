<?php

namespace App\Livewire\Patients;

use App\Events\UserActivityEvent;
use App\Models\Patient;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Delete extends Component
{
    public bool $showModal = false;
    public ?Patient $patient;
    public string $patient_name = '';

    #[Validate('required', message: "You are required to enter the patient's name to confirm deletion.")]
    #[Validate('same:patient_name', message: "The name you entered does not match the patient's name.")]
    public string $confirm_patient_name = '';

    public function mount($patient_id): void
    {
        $this->patient = Patient::find($patient_id);
        $this->patient_name = $this->patient->full_name;
    }

    public function open(): void
    {
        $this->showModal = true;
    }

    public function close(): void
    {
        $this->showModal = false;
        $this->resetErrorBag();
    }

    public function delete(): void
    {
        try {
            $this->patient->delete();

            Log::info('Patient deleted successfully.');

            event(new UserActivityEvent(
                auth()->user(),
                'Patient successfully deleted.',
                "User {auth()->user()->name} successfully deleted patient {$this->patient->full_name}.",
                [
                    'patient_id' => $this->patient->id,
                    'patient_name' => $this->patient->full_name,
                ],
                Carbon::now()->toDateTimeString()
            ));

            session()->flash('success', 'Patient successfully deleted.');
            $this->redirect(route('patients.index'));
        } catch (Exception $e) {
            Log::error('Patient deletion failed. Error: ' . $e->getMessage());

            event(new UserActivityEvent(
                auth()->user(),
                'Patient deletion failed.',
                "User {auth()->user()->name} failed to delete patient {$this->patient->full_name}.",
                [
                    'patient_id' => $this->patient->id,
                    'patient_name' => $this->patient->full_name,
                ],
                Carbon::now()->toDateTimeString()
            ));

            session()->flash('error', 'Patient deletion failed.');
            $this->redirect(route('patients.index'));
        }
    }

    public function render(): View
    {
        return view('livewire.delete-patient-modal');
    }
}
