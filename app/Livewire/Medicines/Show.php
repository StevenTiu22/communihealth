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

    public function mount($medicine_id): void
    {
        $this->medicine = Medicine::findOrFail($medicine_id);
    }

    public function open(): void
    {
        $this->medicine->refresh();
        $this->showModal = true;
    }

    public function close(): void
    {
        $this->showModal = false;
    }

    public function getIsExpiringSoonProperty()
    {
        return !$this->medicine->isExpired() &&
               Carbon::parse($this->medicine->expiry_date)->diffInMonths(now(), true) <= 3.0;
    }

    public function getStockStatusProperty()
    {
        if ($this->medicine->current_stock <= 0) {
            return [
                'label' => 'Out of Stock',
                'classes' => 'bg-yellow-100 text-yellow-800'
            ];
        }
        return [
            'label' => 'In Stock',
            'classes' => 'bg-blue-100 text-blue-800'
        ];
    }

    public function getExpiryStatusProperty()
    {
        if ($this->medicine->isExpired()) {
            return [
                'label' => 'Expired',
                'classes' => 'bg-red-100 text-red-800'
            ];
        }
        return [
            'label' => 'Active',
            'classes' => 'bg-green-100 text-green-800'
        ];
    }

    public function render(): View
    {
        return view('livewire.medicines.show');
    }
}
