<?php

namespace App\Livewire\Users;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    public string $category = '';
    public int $perPage = 10;

    #[On('category-updated')]
    public function updated(string $category): void
    {
        $this->category = $category;

        $this->resetPage();
    }

    public function gotoPage($page): void
    {
        $this->setPage($page);
    }

    public function render(): View
    {
        $query = User::query();

        if (!empty($this->category))
        {
            if ($this->category === 'deleted')
            {
                $query->onlyTrashed();
            }
            else
            {
                $query->role($this->category)->get();
            }
        }
        else
        {
            $query->get();
        }

        $users = $query->paginate($this->perPage);

        return view('livewire.users.table', [
            'users' => $users,
        ]);
    }
}
