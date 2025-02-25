<?php

namespace App\Livewire\Scheduling;

use App\Models\Appointment;
use Livewire\Component;
use Livewire\WithPagination;

class SchedulingTable extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedDoctor = '';
    public $filter = 'all';
    public $dateRange = 'today';

    protected $listeners = [
        'appointment-created' => '$refresh',
        'search-updated' => 'updateSearch',
        'doctor-filter-changed' => 'updateDoctorFilter',
        'date-filter-changed' => 'updateDateFilter',
        'type-filter-changed' => 'updateTypeFilter',
        'filters-reset' => 'resetFilters'
    ];

    public function updateSearch($search)
    {
        $this->search = $search;
    }

    public function updateDoctorFilter($doctor)
    {
        $this->selectedDoctor = $doctor;
    }

    public function updateDateFilter($dateRange)
    {
        $this->dateRange = $dateRange;
    }

    public function updateTypeFilter($filter)
    {
        $this->filter = $filter;
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->selectedDoctor = '';
        $this->filter = 'all';
        $this->dateRange = 'today';
    }

    public function render()
    {
        $appointments = Appointment::query()
            ->with(['patient.user', 'doctor.user', 'appointmentType', 'schedule'])
            ->when($this->search, function ($query) {
                $query->whereHas('patient.user', function ($q) {
                    $q->where('first_name', 'like', '%' . $this->search . '%')
                      ->orWhere('last_name', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->selectedDoctor, function ($query) {
                $query->where('doctor_id', $this->selectedDoctor);
            })
            ->when($this->filter !== 'all', function ($query) {
                $query->where('is_walk_in', $this->filter === 'walk-in');
            })
            ->when($this->dateRange !== 'all', function ($query) {
                match($this->dateRange) {
                    'today' => $query->whereHas('schedule', fn($q) => $q->whereDate('date', today())),
                    'tomorrow' => $query->whereHas('schedule', fn($q) => $q->whereDate('date', today()->addDay())),
                    'week' => $query->whereHas('schedule', fn($q) => $q->whereBetween('date', [now()->startOfWeek(), now()->endOfWeek()])),
                    'month' => $query->whereHas('schedule', fn($q) => $q->whereMonth('date', now()->month)),
                    default => null
                };
            })
            ->latest('recorded_at')
            ->paginate(10);

        return view('livewire.scheduling-table', [
            'appointments' => $appointments
        ]);
    }
}
