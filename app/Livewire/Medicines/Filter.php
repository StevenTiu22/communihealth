<?php

namespace App\Livewire\Medicines;

use App\Models\MedicineCategory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Filter extends Component
{
    public $selectedStatus = '';
    public $selectedCategory = '';
    public $selectedStock = '';
    public $selectedExpiry = '';

    public function updatedSelectedStatus(): void
    {
        $this->dispatch('filter-status', $this->selectedStatus);
    }

    public function updatedSelectedCategory(): void
    {
        $this->dispatch('filter-category', $this->selectedCategory);
    }

    public function updatedSelectedStock(): void
    {
        $this->dispatch('filter-stock', $this->selectedStock);
    }

    public function updatedSelectedExpiry(): void
    {
        $this->dispatch('filter-expiry', $this->selectedExpiry);
    }

    public function resetFilters(): void
    {
        $this->selectedStatus = '';
        $this->selectedCategory = '';
        $this->selectedStock = '';
        $this->selectedExpiry = '';

        $this->dispatch('filter-status', '');
        $this->dispatch('filter-category', '');
        $this->dispatch('filter-stock', '');
        $this->dispatch('filter-expiry', '');

        $this->dispatch('reset-filters');
    }

    public function render(): View
    {
        $categories = MedicineCategory::all();

        return view('livewire.medicines.filter', [
            'categories' => $categories
        ]);
    }
}
