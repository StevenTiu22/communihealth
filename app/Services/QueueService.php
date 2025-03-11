<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\AppointmentQueue;
use Carbon\Carbon;

class QueueService
{
    public function create(array $data): AppointmentQueue
    {
        $appointment = Appointment::create([
            'patient_id' => $data['patient_id'],
            'bhw_id' => $data['bhw_id'],
            'doctor_id' => $data['doctor_id'],
            'appointment_type_id' => $data['appointment_type_id'],
            'appointment_date' => $data['appointment_date'],
            'time_in' => $data['time_in'],
            'chief_complaint' => $data['chief_complaint'],
            'remarks' => $data['remarks'],
        ]);

        $queue_number = $this->generateQueueNumber();

        return $appointment->appointmentQueue()->create([
            'queue_number' => $queue_number,
            'queue_date' => $data['queue_date'],
            'queue_status' => $data['queue_status'],
            'queue_type' => $data['queue_type'],
        ]);
    }

    public function update(AppointmentQueue $queue, array $data): AppointmentQueue
    {
        $queue->forceFill([
            'queue_status' => $data['queue_status'],
            'queue_type' => $data['queue_type'],
            'called_at' => $data['called_at'],
            'completed_at' => $data['completed_at'],
            'remarks' => $data['remarks'],
        ])->save();

        return $queue;
    }

    public static function generateQueueNumber(): int
    {
        // Get current date
        $today = Carbon::now()->toDateString();

        // Find the highest queue number for today
        $highestQueue = AppointmentQueue::where('queue_date', $today)
            ->orderBy('queue_number', 'desc')
            ->first();

        // Determine the next queue number
        $nextQueueNumber = $highestQueue ? $highestQueue->queue_number + 1 : 1;

        // Check if we've hit the limit
        if ($nextQueueNumber > 50) {
            throw new \Exception('Maximum queue capacity (50) reached for today. Please try again tomorrow.');
        }

        return $nextQueueNumber;
    }
}
