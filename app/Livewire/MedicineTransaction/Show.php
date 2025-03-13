<?php

namespace App\Livewire\MedicineTransaction;

use App\Models\MedicineTransaction;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Show extends Component
{
    public bool $showModal = false;
    public MedicineTransaction $transaction;

    public function mount($transaction_id): void
    {
        $this->transaction = MedicineTransaction::find($transaction_id);
    }

    public function open(): void
    {
        $this->showModal = true;
    }

    public function close(): void
    {
        $this->showModal = false;
    }

    public function render(): View
    {
        return view('livewire.medicine-transaction.show');
    }
}
