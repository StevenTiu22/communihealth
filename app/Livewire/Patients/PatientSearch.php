<?php

namespace App\Livewire\Patients;

use Livewire\Component;

class PatientSearch extends Component
{
    public $search = '';

    public function updatedSearch()
    {
        session(['search' => $this->search]);
        $this->emit('searchUpdated', $this->search);
    }

    public function render()
    {
        return view('livewire.patients.patient-search');
    }
} 