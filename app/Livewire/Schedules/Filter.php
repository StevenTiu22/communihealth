<?php

namespace App\Livewire\Schedules;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Filter extends Component
{
    public bool $dropdownOpen = false;
    public string $doctor_id = '';

    public function toggle(): void
    {
        $this->dropdownOpen = !$this->dropdownOpen;
    }

    public function close(): void
    {
        $this->dropdownOpen = false;
    }

    public function updatedDoctorId(): void
    {
        $this->dispatch('schedule-filter-updated', $this->doctor_id);
    }

    public function render(): View
    {
        $doctors = User::query()->role('doctor')->orderBy('last_name', 'asc')->get();

        return view('livewire.schedules.filter', [
            'doctors' => $doctors,
        ]);
    }
}
