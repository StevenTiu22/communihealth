<?php

namespace App\Livewire\Users;

use Livewire\Component;

class Sort extends Component
{
    public $isOpen = false;
    public $sortBy = 'latest_login';

    public function toggleDropdown()
    {
        $this->isOpen = !$this->isOpen;
    }

    public function sort($value)
    {
        $this->sortBy = $value;
        $this->isOpen = false;
        $this->emit('sortChanged', $value);
    }

    public function render()
    {
        return view('livewire.users.sort');
    }
}
