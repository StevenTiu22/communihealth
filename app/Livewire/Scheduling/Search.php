<?php

namespace App\Livewire\Scheduling;

use Livewire\Component;
use Illuminate\Contracts\View\View;

class Search extends Component
{
    public string $search = '';

    public function updated(): void
    {
        $this->dispatch('scheduling-search-updated', $this->search);
    }

    public function render(): View
    {
        return view('livewire.scheduling.search');
    }
}
