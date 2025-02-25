<?php

namespace App\Livewire\Medicines;

use Livewire\Component;

class MedicineSearch extends Component
{
    public $search = '';

    public function updatedSearch()
    {
        $this->dispatch('search-medicines', search: $this->search);
    }

    public function render()
    {
        return view('livewire.medicine-search');
    }
}
