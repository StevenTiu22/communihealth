<?php

namespace App\Livewire\HealthRecords;

use App\Models\Patient;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Filter extends Component
{
    public string $date = '';
    public string $patient = '';

    public function updatedDate(): void
    {
        $this->dispatch('health-records-date-updated', $this->date);
    }

    public function updatedPatient(): void
    {
        $this->dispatch('health-records-patient-updated', $this->patient);
    }

    public function render(): View
    {
        $patients = Patient::orderBy('last_name')->get();

        return view('livewire.health-records.filter', [
            'patients' => $patients,
        ]);
    }
}
