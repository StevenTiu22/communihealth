<?php

namespace App\Livewire;

use Livewire\Component;

class PatientFilter extends Component
{
    public $gender = '';
    public $age = '';
    public $is_4ps = '';
    public $is_nhts = '';

    public function updated($field)
    {
        $this->dispatch('filter-update', filters: [
            'gender' => $this->gender,
            'age' => $this->age,
            'is_4ps' => $this->is_4ps,
            'is_nhts' => $this->is_nhts
        ]);
    }

    public function resetFilters()
    {
        $this->gender = '';
        $this->age = '';
        $this->is_4ps = '';
        $this->is_nhts = '';

        $this->dispatch('filter-update', filters: [
            'gender' => '',
            'age' => '',
            'is_4ps' => '',
            'is_nhts' => ''
        ]);
    }

    public function render()
    {
        return view('livewire.patient-filter');
    }
}
