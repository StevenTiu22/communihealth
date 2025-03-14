<?php

namespace App\Livewire\HealthRecords;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class Search extends Component
{
    public string $search = '';

    public function updatedSearch(): void
    {
        $this->dispatch('health-records-search-updated', $this->search);
    }

    public function render(): View
    {
        return view('livewire.health-records.search');
    }
}
