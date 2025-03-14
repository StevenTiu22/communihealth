<?php

namespace App\Livewire\Medicines;

use App\Models\Medicine;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Show extends Component
{
    public bool $showModal = false;
    public Medicine $medicine;
    public string $created_at = '';
    public string $updated_at = '';

    public function mount($medicine_id): void
    {
        $this->medicine = Medicine::findOrFail($medicine_id);
    }

    public function open(): void
    {
        $this->medicine->refresh();
        $this->created_at = Carbon::parse($this->medicine->created_at)->addHours(8)->format('F j, Y g:i A');
        $this->updated_at = Carbon::parse($this->medicine->updated_at)->addHours(8)->format('F j, Y g:i A');
        $this->showModal = true;
    }

    public function close(): void
    {
        $this->showModal = false;
    }

    public function render(): View
    {
        return view('livewire.medicines.show');
    }
}
