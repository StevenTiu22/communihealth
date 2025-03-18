<?php

namespace App\Livewire\Patients;

use App\Models\Address;
use App\Models\ParentInfo;
use App\Models\Patient;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Show extends Component
{
    public bool $showModal = false;
    public ?Patient $patient;
    public ?Address $address;
    public ?ParentInfo $father;
    public ?ParentInfo $mother;

    public function mount($patient_id): void
    {
        $this->patient = Patient::findOrFail($patient_id);

        if (isset($this->patient->address)) {
            $this->address = $this->patient->address;
        }

        if (isset($this->patient->parents)) {
            $this->father = $this->patient->parents->where('pivot.relationship', 'father')->first();
            $this->mother = $this->patient->parents->where('pivot.relationship', 'mother')->first();
        }
    }

    public function open(): void
    {
        $this->showModal = true;
    }

    public function close(): void
    {
        $this->showModal = false;
    }

    public function render(): View
    {
        return view('livewire.patients.show');
    }
}
