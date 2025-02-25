<?php

namespace App\Livewire\Patients;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class Filter extends Component
{
    public string $gender = '';
    public int $age_from;
    public int $age_to;

    public function applyFilter(): void
    {
        $this->dispatch('patient-filter-updated', [
            'gender' => $this->gender,
            'age_from' => $this->age_from,
            'age_to' => $this->age_to,
        ]);
    }

    public function resetFilter(): void
    {
        $this->reset();
    }

    public function render(): View
    {
        return view('livewire.patients.filter');
    }
}
