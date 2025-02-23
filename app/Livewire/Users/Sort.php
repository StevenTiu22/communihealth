<?php

namespace App\Livewire\Users;

use Livewire\Component;

class Sort extends Component
{
    public string $sort_by = '';
    public string $sort_direction = 'asc';
    public bool $isOpen = false;

    public function toggleDropdown(): void
    {
        $this->isOpen = !$this->isOpen;
    }

    public function sort(string $type): void
    {
        switch ($type) {
            case 'latest_login':
                $this->sort_by = 'last_login_at';
                $this->sort_direction = 'desc';
                break;
            case 'oldest_login':
                $this->sort_by = 'last_login_at';
                $this->sort_direction = 'asc';
                break;
            case 'newest':
                $this->sort_by = 'created_at';
                $this->sort_direction = 'desc';
                break;
            case 'oldest':
                $this->sort_by = 'created_at';
                $this->sort_direction = 'asc';
                break;
        }

        $this->isOpen = false;
        $this->dispatch('user-sort-updated', [
            'sort_by' => $this->sort_by,
            'sort_direction' => $this->sort_direction,
        ]);
    }

    public function render()
    {
        return view('livewire.users.sort');
    }
}
