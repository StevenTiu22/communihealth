<?php

namespace App\Livewire;

use Livewire\Component;

class PatientSearch extends Component
{
    public $search = '';

    public function updatedSearch()
    {
        $this->dispatch('search-update', search: $this->search);
    }

    public function render()
    {
        return view('livewire.patient-search');
    }
}
