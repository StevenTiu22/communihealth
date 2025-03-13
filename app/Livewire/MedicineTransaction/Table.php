<?php

namespace App\Livewire\MedicineTransaction;

use App\Models\MedicineTransaction;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    public int $perPage = 10;
    public string $search = '';
    public string $date = '';

    #[On('medicine-transaction-search-updated')]
    public function updatedSearch($search): void
    {
        $this->search = $search;
    }

    #[On('medicine-transaction-date-updated')]
    public function updatedDate($date): void
    {
        $this->date = $date;
    }

    public function render(): View
    {
        $query = MedicineTransaction::query();

        if(! empty($this->search)) {
            $query->where(function ($query) {
                $query->whereHas('patient', function ($q) {
                    $q->where('first_name', 'like', '%' . $this->search . '%')
                        ->orWhere('last_name', 'like', '%' . $this->search . '%');
                });
            });
        }

        if(! empty($this->date)) {
            switch($this->date) {
                case 'today':
                    $query->whereDate('created_at', now());
                    break;
                case 'this-week':
                    $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'this-month':
                    $query->whereMonth('created_at', now()->month);
                    break;
                case 'this-year':
                    $query->whereYear('created_at', now()->year);
                    break;
            }
        }

        $transactions = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.medicine-transaction.table', [
            'transactions' => $transactions,
        ]);
    }
}
