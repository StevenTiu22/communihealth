<?php

namespace App\Livewire\Schedules;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class Search extends Component
{
    public string $search = '';

    public function updated(): void
    {
        $this->dispatch('schedules-search-updated', $this->search);
    }

    public function render(): View
    {
        return view('livewire.schedules.search');
    }
}
