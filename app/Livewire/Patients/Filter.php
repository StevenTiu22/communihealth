<?php

namespace App\Livewire\Patients;

use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Filter extends Component
{
    public bool $showModal = false;

    public string $sex = '';
    public int $age_from = 0;
    public int $age_to = 120;


    public function applyFilters(): void
    {
        $this->dispatch('patient-filter-updated', [
            'sex' => $this->sex,
            'age_from' => $this->age_from,
            'age_to' => $this->age_to,
        ]);
    }

    public function resetFilters(): void
    {
        $this->reset();
    }

    public function render(): View
    {
        return view('livewire.patients.filter');
    }
}
