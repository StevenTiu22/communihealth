<?php

namespace App\Livewire\Patients;

use Livewire\Component;

class PatientFilter extends Component
{
    public $filters = [
        'gender' => '',
        'age_from' => '',
        'age_to' => '',
    ];

    public function applyFilters()
    {
        session(['filters' => $this->filters]);
        $this->emit('filterApplied', $this->filters);
    }

    public function resetFilters()
    {
        $this->filters = [
            'gender' => '',
            'age_from' => '',
            'age_to' => '',
        ];
        session()->forget('filters');
        $this->emit('filterApplied', []);
    }

    public function render()
    {
        return view('livewire.patients.patient-filter');
    }
} 