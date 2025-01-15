<?php

namespace App\Livewire;

use Livewire\Component;

class UserSearch extends Component
{
    public $search = '';

    public function updatedSearch()
    {
        $this->dispatch('search-updated', search: $this->search);
    }

    public function render()
    {
        return view('livewire.user-search');
    }
}