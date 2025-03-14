<?php

namespace App\Livewire\HealthRecords;

use App\Models\Appointment;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class Show extends Component
{
    public bool $showModal = false;

    public Appointment $appointment;

    #[On('health-records-show-open')]
    public function open($appointment_id): void
    {
        $this->showModal = true;
        $this->appointment = Appointment::find($appointment_id);
    }

    public function close(): void
    {
        $this->showModal = false;
    }

    public function render(): View
    {
        return view('livewire.health-records.show');
    }
}
