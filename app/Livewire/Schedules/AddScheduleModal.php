<?php

namespace App\Livewire\Schedules;

use App\Models\Appointment;
use App\Models\AppointmentType;
use App\Models\Patient;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AddScheduleModal extends Component
{
    public $showModal = false;
    public $patientId;
    public $doctorId;
    public $appointmentTypeId;
    public $chiefComplaint;
    public $appointmentDate;
    public $appointmentTime;
    public $patients;

    protected $listeners = ['openModal'];

    public function openModal()
    {
        $this->showModal = true;
        $this->appointmentDate = Carbon::now()->format('Y-m-d');
        $this->appointmentTime = Carbon::now('Asia/Manila')->format('H:i');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset();
    }

    public function createAppointment()
    {
        $this->validate([
            'patientId' => 'required|exists:users,id',
            'doctorId' => 'required|exists:users,id',
            'appointmentTypeId' => 'required|exists:appointment_types,id',
            'chiefComplaint' => 'required|string|min:5',
            'appointmentDate' => 'required|date|after_or_equal:today',
            'appointmentTime' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $appointment = Appointment::create([
                'patient_id' => $this->patientId,
                'doctor_id' => $this->doctorId,
                'bhw_id' => Auth::id(),
                'appointment_type_id' => $this->appointmentTypeId,
                'chief_complaint' => $this->chiefComplaint,
                'is_walk_in' => false,
                'status' => 'scheduled',
                'recorded_at' => now()
            ]);

            $schedule = Schedule::create([
                'appointment_id' => $appointment->id,
                'date' => $this->appointmentDate,
                'scheduled_time' => $this->appointmentTime,
                'time_in' => null,
            ]);

            DB::commit();

            $this->dispatch('appointment-created');
            session()->flash('success', 'Appointment scheduled successfully.');
            $this->closeModal();
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Failed to schedule appointment.');
        }
    }

    public function mount()
    {
        $this->patients = Patient::query()
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();
    }

    public function render()
    {
        return view('livewire.add-schedule-modal', [
            'appointmentTypes' => AppointmentType::all(),
            'doctors' => User::where('role', 1)->get(),
        ]);
    }
}
