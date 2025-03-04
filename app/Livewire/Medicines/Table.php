<?php

namespace App\Livewire\Medicines;

use App\Models\Medicine;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    public int $perPage = 10;
    public string $search = '';
    public string $status = '';
    public string $category = '';
    public string $stock = '';
    public string $expiry = '';

    #[On('medicine-search-updated')]
    public function updateSearch(string $search): void
    {
        $this->search = $search;

        $this->resetPage();
    }

    #[On('medicine-category-updated')]
    public function updatedCategory($category)
    {
        $this->category = $category;
        $this->resetPage();
    }

    #[On('medicine-stock-updated')]
    public function updatedStock($stock)
    {
        $this->stock = $stock;
        $this->resetPage();
    }

    #[On('medicine-expiry-updated')]
    public function updatedExpiry($expiry)
    {
        $this->expiry = $expiry;
        $this->resetPage();
    }

    #[On('medicine-filters-reset')]
    public function resetFilters(): void
    {
        $this->search = '';
        $this->category = '';
        $this->stock = '';
        $this->expiry = '';

        $this->resetPage();
    }

    public function gotoPage($page): void
    {
        $this->setPage($page);
    }

    public function render(): View
    {
        $query = Medicine::query();

        if (! empty($this->search)) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        if (! empty($this->category)) {
            $query->whereHas('category', function($query) {
                $query->where('id', $this->category);
            });
        }

        if (! empty($this->stock)) {
            if ($this->stock === 'in_stock') {
                $query->where('stock_level', '>', 0);
            } elseif ($this->stock === 'out_of_stock') {
                $query->where('stock_level', 0);
            } elseif ($this->stock === 'low_stock') {
                $query->where('stock_level', '<=', 50);
            }
        }

        if (! empty($this->expiry)) {
            if ($this->expiry === 'expired') {
                $query->where('expiry_date', '<', now());
            } elseif ($this->expiry === 'active') {
                $query->where('expiry_date', '>', now());
            } elseif ($this->expiry === 'expiring_soon') {
                $query->where('expiry_date', '<=', now()->addDays(30));
            }
        }

        $medicines = $query->orderBy('created_at', 'desc')->paginate($this->perPage);

        return view('livewire.medicines.table', [
            'medicines' => $medicines
        ]);
    }
}
