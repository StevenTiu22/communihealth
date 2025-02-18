<?php

namespace App\Livewire\Users;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    public string $category = '';
    public string $search = '';
    public int $perPage = 10;

    #[On('category-updated')]
    public function updateCategory(string $category): void
    {
        $this->category = $category;

        $this->resetPage();
    }

    #[On('search-updated')]
    public function updateSearch(string $search): void
    {
        $this->search = $search;

        $this->resetPage();
    }

    public function gotoPage($page): void
    {
        $this->setPage($page);
    }

    public function render(): View
    {
        $query = User::query();

        if (!empty($this->category)) {
            if ($this->category === 'deleted') {
                $query->onlyTrashed();
            } else {
                $query->role($this->category);
            }
        }

        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('first_name', 'like', '%' . $this->search . '%')
                    ->orWhere('middle_name', 'like', '%' . $this->search . '%')
                    ->orWhere('last_name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('username', 'like', '%' . $this->search . '%');
            });
        }

        $users = $query->paginate($this->perPage);

        return view('livewire.users.table', [
            'users' => $users,
        ]);
    }
}
