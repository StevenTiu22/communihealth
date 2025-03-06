<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'bhw_id',
        'appointment_type_id',
        'treatment_record_id',
        'vital_signs_id',
        'appointment_date',
        'time_in',
        'time_out',
        'chief_complaint',
        'remarks',
        'is_cancelled',
        'cancellation_reason',
    ];

    protected $casts = [
        'is_walk_in' => 'boolean',
        'recorded_at' => 'datetime'
    ];

    public const STATUSES = [
        'scheduled' => 'Scheduled',
        'in_progress' => 'In Progress',
        'completed' => 'Completed',
        'cancelled' => 'Cancelled'
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class, 'user_id');
    }

    public function bhw(): BelongsTo
    {
        return $this->belongsTo(BHW::class, 'user_id');
    }

    public function appointmentType(): BelongsTo
    {
        return $this->belongsTo(AppointmentType::class);
    }

    public function appointmentQueue(): BelongsTo
    {
        return $this->belongsTo(AppointmentQueue::class);
    }
}
