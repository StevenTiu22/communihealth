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
    public string $sort_by = '';
    public string $sort_direction = '';
    public int $perPage = 10;

    #[On('user-category-updated')]
    public function updateCategory(string $category): void
    {
        $this->category = $category;

        $this->resetPage();
    }

    #[On('user-search-updated')]
    public function updateSearch(string $search): void
    {
        $this->search = $search;

        $this->resetPage();
    }

    #[On('user-sort-updated')]
    public function updateSort(array $sort): void
    {
        $this->sort_by = $sort['sort_by'];
        $this->sort_direction = $sort['sort_direction'];

        $this->resetPage();
    }

    public function gotoPage($page): void
    {
        $this->setPage($page);
    }

    public function render(): View
    {
        $query = User::query();

        if (! empty($this->category)) {
            if ($this->category === 'deleted') {
                $query->onlyTrashed();
            } else {
                $query->role($this->category);
            }
        }

        if (! empty($this->search)) {
            $query->where(function($q) {
                $q->where('first_name', 'like', '%' . $this->search . '%')
                    ->orWhere('middle_name', 'like', '%' . $this->search . '%')
                    ->orWhere('last_name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('username', 'like', '%' . $this->search . '%');
            });
        }

        if (! empty($this->sort_by) && ! empty($this->sort_direction)) {
            $query->orderBy($this->sort_by, $this->sort_direction);
        }

        $users = $query->paginate($this->perPage);

        return view('livewire.users.table', [
            'users' => $users,
        ]);
    }
}
