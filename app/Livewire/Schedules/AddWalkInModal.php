<?php

namespace App\Livewire\Schedules;

use App\Models\Appointment;
use App\Models\AppointmentType;
use App\Models\Patient;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AddWalkInModal extends Component
{
    public $showModal = false;
    public $patients;
    public $doctorId;
    public $appointmentTypeId;
    public $chiefComplaint;

    protected $listeners = ['openModal'];

    public function mount()
    {
        $this->patients = Patient::query()
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();
    }

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset([
            'doctorId', 'appointmentTypeId', 'chiefComplaint'
        ]);
    }

    public function createWalkIn()
    {
        $this->validate([
            'patientId' => 'required|exists:users,id',
            'doctorId' => 'required|exists:users,id',
            'appointmentTypeId' => 'required|exists:appointment_types,id',
            'chiefComplaint' => 'required|string|min:5',
        ]);

        try {
            DB::beginTransaction();

            $appointment = Appointment::create([
                'patient_id' => $this->patientId,
                'doctor_id' => $this->doctorId,
                'bhw_id' => Auth::id(),
                'appointment_type_id' => $this->appointmentTypeId,
                'chief_complaint' => $this->chiefComplaint,
                'is_walk_in' => true,
                'status' => 'in_progress',
                'recorded_at' => now()
            ]);

            $schedule = Schedule::create([
                'appointment_id' => $appointment->id,
                'date' => now()->toDateString(),
                'scheduled_time' => now()->format('H:i:s'),
                'time_in' => now(),
            ]);

            DB::commit();

            $this->dispatch('appointment-created');
            session()->flash('success', 'Walk-in patient registered successfully.');
            $this->closeModal();
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Failed to register walk-in patient.');
        }
    }

    public function render()
    {
        return view('livewire.add-walk-in-modal', [
            'appointmentTypes' => AppointmentType::all(),
            'doctors' => User::where('role', 1)->get(),
            'patients' => User::where('role', 2)->get(),
        ]);
    }
}
