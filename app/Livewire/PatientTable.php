<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use App\Models\Patient;
use Livewire\Component;
use Livewire\WithPagination;

class PatientTable extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'id';
    public $sortDirection = 'asc';
    public $filterGender = '';
    public $filterAge = '';
    public $filter4ps = '';
    public $filterNhts = '';

    #[On('search-update')] 
    public function updateSearch($search)
    {
        $this->resetPage();
        $this->search = $search;
    }

    #[On('filter-update')]
    public function filterStatus($filters)
    {
        $this->resetPage();
        $this->filterGender = $filters['gender'];
        $this->filterAge = $filters['age'];
        $this->filter4ps = $filters['is_4ps'];
        $this->filterNhts = $filters['is_nhts'];
    }

    public function sortBy($field)
    {
        if ($field === 'age') {
            $this->sortField = 'birth_date';
            if ($this->sortField === 'birth_date') {
                $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
            } else {
                $this->sortDirection = 'asc';
            }
        } else {
            if ($this->sortField === $field) {
                $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
            } else {
                $this->sortField = $field;
                $this->sortDirection = 'asc';
            }
        }
    }

    public function render()
    {
        $query = Patient::query();

        // Apply search if it exists
        if (!empty($this->search)) {
            $searchPattern = '%' . $this->search . '%';
            $query->where(function($q) use ($searchPattern) {
                $q->where('first_name', 'like', $searchPattern)
                  ->orWhere('middle_name', 'like', $searchPattern)
                  ->orWhere('last_name', 'like', $searchPattern)
                  ->orWhere('contact_number', 'like', $searchPattern);
            });
        }

        // Apply gender filter if selected
        if ($this->filterGender) {
            $query->where('gender', $this->filterGender);
        }

        // Apply age filter if selected
        if ($this->filterAge !== '') {
            switch ($this->filterAge) {
                case 'child':
                    $query->whereRaw('TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) < 18');
                    break;
                case 'adult':
                    $query->whereRaw('TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) BETWEEN 18 AND 59');
                    break;
                case 'senior':
                    $query->whereRaw('TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) >= 60');
                    break;
            }
        }

        // Apply 4Ps filter if selected
        if ($this->filter4ps !== '') {
            $query->where('is_4ps', $this->filter4ps);
        }

        // Apply NHTS filter if selected
        if ($this->filterNhts !== '') {
            $query->where('is_nhts', $this->filterNhts);
        }

        // Apply sorting
        $query->orderBy($this->sortField, $this->sortDirection);

        $patients = $query->paginate($this->perPage);

        return view('livewire.patient-table', [
            'patients' => $patients
        ]);
    }
}
