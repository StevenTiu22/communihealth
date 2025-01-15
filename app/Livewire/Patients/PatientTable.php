<?php

namespace App\Livewire\Patients;

use App\Models\Patient;
use Livewire\Component;
use Livewire\WithPagination;

class PatientTable extends Component
{
    use WithPagination;

    public function render()
    {
        $patients = Patient::query()
            ->when(session('search'), function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                      ->orWhere('last_name', 'like', "%{$search}%");
                });
            })
            ->when(session('filters'), function ($query, $filters) {
                // Apply filters
                foreach ($filters as $field => $value) {
                    if ($value) {
                        $query->where($field, $value);
                    }
                }
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.patients.patient-table', [
            'patients' => $patients
        ]);
    }
} 