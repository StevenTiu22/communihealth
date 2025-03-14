<?php

namespace App\Livewire\MedicineTransaction;

use Illuminate\View\View;
use Livewire\Component;

class Filter extends Component
{
    public string $date = '';

    public function updatedDate($date): void
    {
        $this->dispatch('medicine-transaction-date-updated', $date);
    }

    public function render(): View
    {
        return view('livewire.medicine-transaction.filter');
    }
}
