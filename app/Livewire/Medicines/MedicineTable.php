<?php

namespace App\Livewire\Medicines;

use App\Models\Medicine;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class MedicineTable extends Component
{
    use WithPagination;

    public int $perPage = 10;
    public string $search = '';
    public $sortField = 'name';
    public $sortDirection = 'asc';
    public $filterStatus = '';
    public $filterCategory = '';
    public $filterStock = '';
    public $filterExpiry = '';

    #[On('medicine-search-updated')]
    public function updateSearch(string $search): void
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
        $query = Medicine::query();

        if (! empty($this->search)) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        $medicines = $query->orderBy('created_at', 'desc')->paginate($this->perPage);

        return view('livewire.medicines.table', [
            'medicines' => $medicines
        ]);
    }
}
