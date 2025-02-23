<?php

namespace App\Livewire\Patients;

use App\Models\Patient;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;

class Edit extends Component
{
    public bool $show = false;
    public ?Patient $patient = null;

    #[Rule('required|string|max:255')]
    public $first_name = '';

    #[Rule('nullable|string|max:255')]
    public $middle_name = '';

    #[Rule('required|string|max:255')]
    public $last_name = '';

    #[Rule('required|in:male,female')]
    public $sex = '';

    #[Rule('required|date')]
    public $birthdate = '';

    #[Rule('boolean')]
    public $is_4ps = false;

    #[Rule('boolean')]
    public $is_NHTS = false;

    #[Rule('nullable|string|max:255')]
    public $contact_num = '';

    #[Rule('nullable|email|max:255')]
    public $email = '';

    #[On('edit-patient')]
    public function open(Patient $patient)
    {
        $this->patient = $patient;
        $this->first_name = $patient->first_name;
        $this->middle_name = $patient->middle_name;
        $this->last_name = $patient->last_name;
        $this->sex = $patient->sex;
        $this->birthdate = $patient->birthdate->format('Y-m-d');
        $this->is_4ps = $patient->is_4ps;
        $this->is_NHTS = $patient->is_NHTS;
        $this->contact_num = $patient->contact_num;
        $this->email = $patient->email;
        $this->show = true;
    }

    public function close()
    {
        $this->show = false;
        $this->reset();
    }

    public function save()
    {
        $validated = $this->validate();

        $this->patient->update($validated);

        $this->dispatch('patient-updated');
        $this->close();
    }

    public function render()
    {
        return view('livewire.patients.edit-patient-modal');
    }
}
