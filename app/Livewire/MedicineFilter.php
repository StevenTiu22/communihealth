<?php

namespace App\Livewire;

use App\Models\MedicineCategory;
use Livewire\Component;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class MedicineFilter extends Component
{
    public $selectedStatus = '';
    public $selectedCategory = '';
    public $selectedStock = '';
    public $selectedExpiry = '';

    protected $listeners = [
        'categoryAdded' => 'clearCategoriesCache',
        'categoryUpdated' => 'clearCategoriesCache',
        'categoryDeleted' => 'clearCategoriesCache'
    ];

    public function mount()
    {
        $this->resetFilters();
    }

    public function updatedSelectedStatus()
    {
        $this->dispatch('filter-status', $this->selectedStatus);
    }

    public function updatedSelectedCategory()
    {
        $this->dispatch('filter-category', $this->selectedCategory);
    }

    public function updatedSelectedStock()
    {
        $this->dispatch('filter-stock', $this->selectedStock);
    }

    public function updatedSelectedExpiry()
    {
        $this->dispatch('filter-expiry', $this->selectedExpiry);
    }

    public function resetFilters()
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

    public function clearCategoriesCache()
    {
        Cache::forget('medicine_categories');
    }

    private function getCategories()
    {
        try {
            return Cache::remember('medicine_categories', 3600, function () {
                $categories = MedicineCategory::query()
                    ->select('id', 'name')
                    ->orderBy('name')
                    ->get();

                if ($categories->isEmpty()) {
                    Log::info('No medicine categories found');
                }

                return $categories;
            });
        } catch (\Exception $e) {
            Log::error('Error fetching medicine categories: ' . $e->getMessage());
            
            // Attempt to get fresh data without cache in case of cache issues
            try {
                return MedicineCategory::select('id', 'name')
                    ->orderBy('name')
                    ->get();
            } catch (\Exception $innerE) {
                Log::error('Failed to fetch categories without cache: ' . $innerE->getMessage());
                return collect(); // Return empty collection as fallback
            }
        }
    }

    public function boot()
    {
        // Clear categories cache if it's older than 1 hour
        if (Cache::has('medicine_categories') && 
            Cache::get('medicine_categories_timestamp', 0) < now()->subHour()->timestamp) {
            $this->clearCategoriesCache();
        }
    }

    public function render()
    {
        $categories = $this->getCategories();

        // Update cache timestamp
        Cache::put('medicine_categories_timestamp', now()->timestamp, 3600);

        return view('livewire.medicine-filter', [
            'categories' => $categories
        ]);
    }
}
