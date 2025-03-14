<?php

namespace App\Livewire\Patients;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class Search extends Component
{
    public string $search = '';

    public function updated(): void
    {
        $this->dispatch('patient-search-updated', $this->search);
    }

    public function render(): View
    {
        return view('livewire.patients.search');
    }
}
