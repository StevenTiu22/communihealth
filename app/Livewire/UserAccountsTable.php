<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;

class UserAccountsTable extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedRoles = [];
    public $perPage = 10;

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
        $users = User::query()
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->where('first_name', 'like', '%' . $this->search . '%')
                        ->orWhere('middle_name', 'like', '%' . $this->search . '%')
                        ->orWhere('last_name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhere('contact_number', 'like', '%' . $this->search . '%');
                });
            })
            ->when(!empty($this->selectedRoles), function ($query) {
                $query->whereIn('role', $this->selectedRoles);
            })
            ->paginate($this->perPage);

        return view('livewire.user-accounts-table', [
            'users' => $users,
        ]);
    }
}
