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
        'chief_complaint',
        'status',
        'is_walk_in',
        'recorded_at'
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
        return $this->belongsTo(User::class, 'patient_id');
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

    public function schedule(): HasOne
    {
        return $this->hasOne(Schedule::class);
    }

    // Helper methods
    public function getScheduledDateAttribute()
    {
        return $this->schedule?->date;
    }

    public function getScheduledTimeAttribute()
    {
        return $this->schedule?->scheduled_time;
    }
} 