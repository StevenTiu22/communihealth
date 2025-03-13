<?php

namespace App\Livewire\Schedules;

use App\Models\AppointmentQueue;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Show extends Component
{
    public ?AppointmentQueue $appointment_queue;
    public bool $showModal = false;

    public function mount($appointment_queue_id): void
    {
        $this->appointment_queue = AppointmentQueue::findOrFail($appointment_queue_id);
    }

    public function open(): void
    {
        $this->showModal = true;
    }

    public function close(): void
    {
        $this->showModal = false;
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function render(): View
    {
        return view('livewire.schedules.show');
    }
}
