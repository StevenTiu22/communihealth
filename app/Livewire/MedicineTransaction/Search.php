<?php

namespace App\Livewire\MedicineTransaction;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class Search extends Component
{
    public string $search = '';

    public function updatedSearch($search): void
    {
        $this->dispatch('medicine-transaction-search-updated', $search);
    }

    public function render(): View
    {
        return view('livewire.medicine-transaction.search');
    }
}
