<?php

namespace App\View\Components;

use Closure;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DeleteUserModal extends Component
{
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.delete-user-modal');
    }
}
