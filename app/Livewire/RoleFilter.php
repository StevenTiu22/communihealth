<?php

namespace App\Livewire;

use Livewire\Component;

class RoleFilter extends Component
{
    public $selectedRoles = [];

    public function updatedSelectedRoles()
    {
        $this->dispatch('role-selected', selectedRoles: $this->selectedRoles);
    }

    public function render()
    {
        $roles = [
            ['value' => '0', 'label' => 'Barangay Official'],
            ['value' => '1', 'label' => 'BHW'],
            ['value' => '2', 'label' => 'Doctor'],
            ['value' => '3', 'label' => 'Patient'],
        ];

        return view('livewire.role-filter', [
            'roles' => $roles
        ]);
    }
} 