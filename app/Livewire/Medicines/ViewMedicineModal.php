<?php

namespace App\Livewire\Medicines;

use App\Models\Medicine;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class ViewMedicineModal extends Component
{
    public $showModal = false;
    public Medicine $medicine;

    public function mount(Medicine $medicine)
    {
        try {
            $this->medicine = $medicine->load('category');
        } catch (\Exception $e) {
            Log::error('Error loading medicine details', [
                'medicine_id' => $medicine->id,
                'error' => $e->getMessage()
            ]);
            session()->flash('error', 'Error loading medicine details.');
        }
    }

    public function openModal()
    {
        try {
            // Refresh medicine data when opening modal
            $this->medicine->refresh();
            $this->showModal = true;
        } catch (\Exception $e) {
            Log::error('Error opening medicine modal', [
                'medicine_id' => $this->medicine->id,
                'error' => $e->getMessage()
            ]);
            session()->flash('error', 'Error loading medicine details.');
        }
    }

    public function closeModal()
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

    public function render()
    {
        return view('livewire.view-medicine-modal');
    }
}
