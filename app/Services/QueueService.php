<?php

namespace App\Services;

use App\Models\AppointmentQueue;
use Carbon\Carbon;

class QueueService
{
    public function create(array $data): AppointmentQueue
    {
        $queue_number = $this->generateQueueNumber();

        return AppointmentQueue::create([
            'appointment_id' => $data['appointment_id'],
            'queue_number' => $queue_number,
            'queue_date' => $data['queue_date'],
            'queue_status' => $data['queue_status'],
            'queue_type' => $data['queue_type'],
            'remarks' => $data['remarks'],
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
