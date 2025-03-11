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
        'time_in' => 'timestamp',
        'time_out' => 'timestamp',
        'appointment_date' => 'datetime:Y-m-d',
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
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function bhw(): BelongsTo
    {
        return $this->belongsTo(User::class, 'bhw_id');
    }

    public function appointmentType(): BelongsTo
    {
        return $this->belongsTo(AppointmentType::class);
    }

    public function vitalSign(): BelongsTo
    {
        return $this->belongsTo(VitalSign::class, 'vital_signs_id');
    }

    public function treatmentRecord(): BelongsTo
    {
        return $this->belongsTo(TreatmentRecord::class, 'treatment_record_id');
    }

    public function appointmentQueue(): HasOne
    {
        return $this->hasOne(AppointmentQueue::class);
    }
}
