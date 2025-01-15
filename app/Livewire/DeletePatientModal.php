<?php

namespace App\Livewire;

use Livewire\Component;

class DeletePatientModal extends Component
{
    public $showModal = false;
    
    public $patient;

    public function mount($patient)
    {
        $this->patient = $patient;
    }

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function delete()
    {
        $this->patient->delete();
        $this->closeModal();
        session()->flash('success', 'Patient record deleted successfully.');
        return redirect()->route('patient-records.index');
    }

    public function render()
    {
        return view('livewire.delete-patient-modal');
    }
}
