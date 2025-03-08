<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AppointmentQueue extends Model
{
    protected $fillable = [
        'appointment_id',
        'queue_number',
        'queue_date',
        'queue_status',
        'queue_type',
        'called_at',
        'completed_at',
    ];

    protected $casts = [
        'queue_date' => 'date',
        'called_at' => 'datetime:Y-m-d H:i:s',
        'completed_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }
}
