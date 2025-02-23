<?php

namespace App\Livewire\Users;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class Search extends Component
{
    public string $search = '';

    public function updated(): void
    {
        $this->dispatch('user-search-updated', $this->search);
    }

    public function render(): View
    {
        return view('livewire.users.search');
    }
}
