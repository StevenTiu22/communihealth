<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
<<<<<<< HEAD
    public function __construct(
        public string $title
    ){}
=======
>>>>>>> 6e27fc8f819ab12cb9a87b13b18e6246c488fc80
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('layouts.app');
    }
}
