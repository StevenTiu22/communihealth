<?php

namespace App\Livewire\Users;

use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedRoles = [];
    public $perPage = 10;

    public ?User $users = null;

    protected $queryString = ['search', 'role', 'perPage'];

    protected $listeners = ['pageChanged' => 'gotoPage'];

    #[On('search-updated')]
    public function updatingSearch($search)
    {
        $this->search = $search;
        $this->resetPage();
    }

    #[On('role-selected')]
    public function updatingRole($selectedRoles)
    {
        $this->selectedRoles = $selectedRoles;
        $this->resetPage();
    }

    public function gotoPage($page)
    {
        $this->setPage($page);
    }

    public function render()
    {
        return view('livewire.users.table');
    }
}
