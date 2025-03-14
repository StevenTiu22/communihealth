<?php

namespace App\Livewire\HealthRecords;

use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    public string $search = '';
    public string $date = '';
    public string $patient = '';

    #[On('health-records-search-updated')]
    public function updatedSearch($search): void
    {
        $this->search = $search;
        $this->resetPage();
    }

    #[On('health-records-date-updated')]
    public function updatedDate($date): void
    {
        $this->date = $date;
        $this->resetPage();
    }

    #[On('health-records-patient-updated')]
    public function updatedPatient($patient): void
    {
        $this->patient = $patient;
        $this->resetPage();
    }

    public function openShowModal($appointment_id): void
    {
        $this->dispatch('health-records-show-open', $appointment_id);
    }

    public function openEditVitalSign($appointment_id): void
    {
        $this->dispatch('health-records-edit-vital-sign-open', $appointment_id);
    }

    public function openEditTreatmentRecord($appointment_id): void
    {
        $this->dispatch('health-records-edit-treatment-record-open', $appointment_id);
    }

    public function render(): View
    {
        $query = Appointment::where('is_cancelled', 0)
            ->whereNotNull('doctor_id')
            ->whereNotNull('treatment_record_id')
            ->whereNotNull('vital_signs_id')
            ->with(['appointmentType', 'patient', 'doctor', 'bhw', 'treatmentRecord', 'vitalSign'])
            ->orderBy('created_at', 'desc');

        if (! empty($this->search)) {
            $query->where(function ($query) {
                $query->whereHas('patient', function ($q) {
                    $q->where('first_name', 'like', '%' . $this->search . '%')
                        ->orWhere('last_name', 'like', '%' . $this->search . '%');
                });
            });
        }

        if (! empty($this->date)) {
            switch ($this->date) {
                case 'today':
                    $query->whereDate('appointment_date', Carbon::today());
                    break;
                case 'week':
                    $query->whereBetween('appointment_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                    break;
                case 'month':
                    $query->whereMonth('appointment_date', Carbon::now()->month)
                        ->whereYear('appointment_date', Carbon::now()->year);
                    break;
                case 'year':
                    $query->whereYear('appointment_date', Carbon::now()->year);
                    break;
            }
        }

        if (! empty($this->patient)) {
            $query->whereHas('patient', function ($q) {
                $q->where('id', '=', $this->patient);
            });
        }

        $health_records = $query->paginate(10);

        return view('livewire.health-records.table', [
            'health_records' => $health_records,
        ]);
    }
}
