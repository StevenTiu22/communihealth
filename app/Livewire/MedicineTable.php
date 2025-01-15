<?php

namespace App\Livewire;

use App\Models\Medicine;
use Livewire\Component;
use Livewire\WithPagination;

class MedicineTable extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = 'name';
    public $sortDirection = 'asc';
    public $filterStatus = '';
    public $filterCategory = '';
    public $filterStock = '';
    public $filterExpiry = '';

    protected $listeners = [
        'search-medicines' => 'updateSearch',
        'medicine-added' => '$refresh',
        'medicine-updated' => '$refresh',
        'medicine-deleted' => '$refresh',
        'filter-status' => 'filterByStatus',
        'filter-category' => 'filterByCategory',
        'filter-stock' => 'filterByStock',
        'filter-expiry' => 'filterByExpiry',
        'reset-filters' => 'resetFilters'
    ];

    public function updateSearch($search)
    {
        $this->search = $search;
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function filterByStatus($status)
    {
        $this->filterStatus = $status;
        $this->resetPage();
    }

    public function filterByCategory($category)
    {
        $this->filterCategory = $category;
        $this->resetPage();
    }

    public function filterByStock($stock)
    {
        $this->filterStock = $stock;
        $this->resetPage();
    }

    public function filterByExpiry($expiry)
    {
        $this->filterExpiry = $expiry;
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->filterStatus = '';
        $this->filterCategory = '';
        $this->resetPage();
    }

    public function render()
    {
        $medicines = Medicine::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('generic_name', 'like', '%' . $this->search . '%')
                      ->orWhere('manufacturer', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterStatus, function ($query) {
                if ($this->filterStatus === 'active') {
                    $query->where('current_stock', '>', 0)
                          ->whereDate('expiry_date', '>', now());
                } elseif ($this->filterStatus === 'inactive') {
                    $query->where('current_stock', 0)
                          ->orWhereDate('expiry_date', '<=', now());
                }
            })
            ->when($this->filterCategory, function ($query) {
                $query->where('category_id', $this->filterCategory);
            })
            ->when($this->filterStock, function ($query) {
                switch ($this->filterStock) {
                    case 'in_stock':
                        $query->where('current_stock', '>', 0);
                        break;
                    case 'out_of_stock':
                        $query->where('current_stock', 0);
                        break;
                    case 'low_stock':
                        $query->where('current_stock', '>', 0)
                              ->where('current_stock', '<=', 100);
                        break;
                }
                //isa po akong hatdog uwuuwu - 202
            })
            ->when($this->filterExpiry, function ($query) {
                switch ($this->filterExpiry) {
                    case 'active':
                        $query->where('expiry_date', '>', now());
                        break;
                    case 'expired':
                        $query->where('expiry_date', '<=', now());
                        break;
                    case 'expiring_soon':
                        $query->where('expiry_date', '>', now())
                              ->where('expiry_date', '<=', now()->addMonths(3));
                        break;
                }
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->with('category')
            ->paginate(10);

        return view('livewire.medicine-table', [
            'medicines' => $medicines
        ]);
    }
} 