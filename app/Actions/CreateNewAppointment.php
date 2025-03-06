<?php

namespace App\Actions;

use App\Models\Appointment;
use App\Models\AppointmentType;

class CreateNewAppointment
{
    public function create(array $input): Appointment
    {
        $appointment_type = AppointmentType::firstOrCreate([
            'name' => $input['appointment_type'],
            'description' => $input['description'],
            'duration_minutes' => $input['duration_minutes'],
        ]);

        return $appointment_type->appointments->create([
            'patient_id' => $input['patient_id'],
            'doctor_id' => $input['doctor_id'],
            'bhw_id' => $input['bhw_id'],
            'appointment_date' => $input['appointment_date'],
            'chief_complaint' => $input['chief_complaint'],
            'remarks' => $input['remarks'],
            'is_cancelled' => $input['is_cancelled'],
        ]);
    }
}
