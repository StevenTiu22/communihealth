<?php

namespace App\Livewire\AuditTrail;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Activitylog\Models\Activity;

class Table extends Component
{
    use WithPagination;

    public $search = '';
    public $actionFilter = '';
    public $perPage = 10;

    protected $queryString = [
        'search' => ['except' => ''],
        'actionFilter' => ['except' => '']
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingActionFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Activity::query()
            ->with('causer')
            ->orderBy('created_at', 'desc');

        if ($this->search) {
            $query->where(function($q) {
                $q->where('log_name', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->actionFilter) {
            $query->where('description', 'like', '%' . $this->actionFilter . '%');
        }

        $activity_logs = $query->paginate($this->perPage);

        return view('livewire.audit-trail.table', [
            'activityLogs' => $activity_logs
        ]);
    }
}
