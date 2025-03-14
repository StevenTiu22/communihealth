<?php

namespace App\Livewire\Users;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class CategoryFilter extends Component
{
    public string $category = '';

    public function updated(): void
    {
        $this->dispatch('user-category-updated', $this->category);
    }

    public function render(): View
    {
        return view('livewire.users.category-filter');
    }
}
