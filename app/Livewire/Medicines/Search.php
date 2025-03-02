<?php

namespace App\Livewire\Medicines;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class Search extends Component
{
    public string $search = '';

    public function updated(): void
    {
        $this->dispatch('medicine-search-updated', search: $this->search);
    }

    public function render(): View
    {
        return view('livewire.medicines.search');
    }
}
