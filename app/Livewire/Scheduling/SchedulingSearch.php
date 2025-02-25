<?php

namespace App\Livewire\Scheduling;

use Livewire\Component;

class SchedulingSearch extends Component
{
    public $search = '';

    protected $queryString = [
        'search' => ['except' => '']
    ];

    public function updatedSearch()
    {
        $this->dispatch('search-updated', search: $this->search);
    }

    public function resetSearch()
    {
        $this->search = '';
        $this->dispatch('search-reset');
    }

    public function render()
    {
        return view('livewire.scheduling-search');
    }
}
