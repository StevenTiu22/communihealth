<?php

namespace App\Livewire\Schedules;

use App\Models\Appointment;
use Livewire\Component;
use Livewire\WithPagination;

class AppointmentList extends Component
{
    use WithPagination;

    public $search = '';
    public $filter = 'all'; // all, walk-in, scheduled
    public $dateRange = 'today'; // today, week, month, all

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Appointment::query()
            ->with(['patient', 'doctor', 'bhw', 'appointmentType'])
            ->when($this->search, function ($query) {
                $query->whereHas('patient', function ($q) {
                    $q->where('first_name', 'like', '%' . $this->search . '%')
                      ->orWhere('last_name', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filter !== 'all', function ($query) {
                $query->where('is_walk_in', $this->filter === 'walk-in');
            })
            ->when($this->dateRange !== 'all', function ($query) {
                match($this->dateRange) {
                    'today' => $query->whereDate('appointment_date', today()),
                    'week' => $query->whereBetween('appointment_date', [now()->startOfWeek(), now()->endOfWeek()]),
                    'month' => $query->whereMonth('appointment_date', now()->month),
                    default => null
                };
            })
            ->latest('recorded_at')
            ->paginate(10);

        return view('livewire.appointment-list', [
            'appointments' => $query
        ]);
    }
}
