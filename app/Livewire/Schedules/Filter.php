<?php

namespace App\Livewire\Schedules;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class Filter extends Component
{


    public function render(): View
    {
        return view('livewire.schedules.filter');
    }
}
