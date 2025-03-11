<?php

namespace App\Livewire\Schedules;

use App\Models\AppointmentQueue;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class Show extends Component
{
    public ?AppointmentQueue $appointment_queue;
    public bool $showModal = false;

    #[On('schedules-show-details')]
    public function open($appointment_queue): void
    {
        $this->showModal = true;
        $this->appointment_queue = $appointment_queue;
    }

    public function close(): void
    {
        $this->showModal = false;
        $this->resetErrorBag();
        $this->resetValidation();
        $this->reset();
    }

    public function render(): View
    {
        return view('livewire.schedules.show');
    }
}
