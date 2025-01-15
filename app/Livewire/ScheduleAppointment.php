<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Appointment;
use App\Models\AppointmentType;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ScheduleAppointment extends Component
{
    public $isWalkIn = false;
    public $patientId;
    public $doctorId;
    public $appointmentTypeId;
    public $chiefComplaint;
    public $appointmentDate;
    public $appointmentTime;
    
    public $availableDoctors = [];
    public $appointmentTypes = [];

    protected function rules()
    {
        return [
            'patientId' => 'required|exists:users,id',
            'doctorId' => 'required|exists:users,id',
            'appointmentTypeId' => 'required|exists:appointment_types,id',
            'chiefComplaint' => 'required|string|min:5',
            'appointmentDate' => 'required|date|' . ($this->isWalkIn ? 'today' : 'after:today'),
            'appointmentTime' => 'required',
        ];
    }

    public function mount()
    {
        $this->appointmentTypes = AppointmentType::all();
        $this->appointmentDate = now()->format('Y-m-d');
        if ($this->isWalkIn) {
            $this->appointmentTime = now()->format('H:i');
        }
    }

    public function updatedAppointmentTypeId()
    {
        if ($this->appointmentTypeId) {
            // Get doctors who specialize in this type of appointment
            $this->availableDoctors = User::where('role', 1) // assuming 1 is doctor role
                ->whereHas('doctor.specializations', function ($query) {
                    $query->where('appointment_type_id', $this->appointmentTypeId);
                })
                ->get();
        }
    }

    public function save()
    {
        $this->validate();

        try {
            DB::beginTransaction();

            $appointment = Appointment::create([
                'patient_id' => $this->patientId,
                'doctor_id' => $this->doctorId,
                'bhw_id' => Auth::id(),
                'appointment_type_id' => $this->appointmentTypeId,
                'chief_complaint' => $this->chiefComplaint,
                'is_walk_in' => $this->isWalkIn,
                'status' => 'scheduled',
                'recorded_at' => now()
            ]);

            // Create the schedule
            $appointment->schedule()->create([
                'date' => $this->appointmentDate,
                'scheduled_time' => $this->appointmentTime,
            ]);

            DB::commit();

            session()->flash('success', 
                $this->isWalkIn 
                    ? 'Walk-in appointment recorded successfully.' 
                    : 'Appointment scheduled successfully.'
            );
            $this->reset();
            $this->redirectRoute('appointments.index');

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Failed to schedule appointment. Please try again.');
        }
    }

    public function render()
    {
        return view('livewire.schedule-appointment');
    }
} 