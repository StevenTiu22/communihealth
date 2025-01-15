<?php

namespace App\Livewire;

use App\Models\Doctor;
use Livewire\Component;

class ScheduleFilter extends Component
{
    public $selectedDoctor = '';
    public $dateRange = 'today';
    public $filter = 'all';
    public $doctors;
    public $isExpanded = false;

    protected $queryString = [
        'selectedDoctor' => ['except' => ''],
        'dateRange' => ['except' => 'today'],
        'filter' => ['except' => 'all']
    ];

    public function mount()
    {
        $this->doctors = Doctor::with('user')->get();
    }

    public function toggleFilters()
    {
        $this->isExpanded = !$this->isExpanded;
    }

    public function updatedSelectedDoctor()
    {
        $this->dispatch('doctor-filter-changed', doctor: $this->selectedDoctor);
    }

    public function updatedDateRange()
    {
        $this->dispatch('date-filter-changed', dateRange: $this->dateRange);
    }

    public function updatedFilter()
    {
        $this->dispatch('type-filter-changed', filter: $this->filter);
    }

    public function resetFilters()
    {
        $this->selectedDoctor = '';
        $this->dateRange = 'today';
        $this->filter = 'all';
        $this->dispatch('filters-reset');
    }

    public function render()
    {
        return view('livewire.schedule-filter');
    }
} 