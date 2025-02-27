<?php

namespace App\Livewire\Patients;

use App\Models\Patient;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    public int $perPage = 10;
    public string $search = '';
    public string $sex = '';
    public int $age_from;
    public int $age_to;

    public function gotoPage($page): void
    {
        $this->setPage($page);
    }

    #[On('patient-search-updated')]
    public function updatedSearch(string $search): void
    {
        $this->search = $search;

        $this->resetPage();
    }

    #[On('patient-filter-updated')]
    public function updatedFilter(array $filters): void
    {
        $this->sex = $filters['sex'];
        $this->age_from = $filters['age_from'];
        $this->age_to = $filters['age_to'];

        $this->resetPage();
    }

    public function render(): View
    {
        $query = Patient::query();

        if (! empty($this->search)) {
            $query->where('first_name', 'like', '%' . $this->search . '%')
                ->orWhere('middle_name', 'like', '%' . $this->search . '%')
                ->orWhere('last_name', 'like', '%' . $this->search . '%');
        }

        if (! empty($this->sex)) {
            $query->where('sex', $this->sex);
        }

        if (! empty($this->age_from)) {
            $query->whereRaw('TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) >= ?', [$this->age_from]);
        }

        if (! empty($this->age_to)) {
            $query->whereRaw('TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) <= ?', [$this->age_to]);
        }

        $patients = $query->paginate($this->perPage);

        return view('livewire.patients.table', [
            'patients' => $patients,
        ]);
    }
}
