<?php

namespace App\Livewire\Medicines;

use App\Models\MedicineCategory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Filter extends Component
{
    public string $selectedStatus = '';
    public string $selectedCategory = '';
    public string $selectedStock = '';
    public string $selectedExpiry = '';

    public function updatedSelectedCategory(): void
    {
        $this->dispatch('medicine-category-updated', $this->selectedCategory);
    }

    public function updatedSelectedStock(): void
    {
        $this->dispatch('medicine-stock-updated', $this->selectedStock);
    }

    public function updatedSelectedExpiry(): void
    {
        $this->dispatch('medicine-expiry-updated', $this->selectedExpiry);
    }

    public function resetFilters(): void
    {
        $this->dispatch('medicine-filters-reset');
        $this->selectedExpiry = '';
        $this->selectedCategory = '';
        $this->selectedStock = '';
    }

    public function render(): View
    {
        $categories = MedicineCategory::all();

        return view('livewire.medicines.filter', [
            'categories' => $categories
        ]);
    }
}
