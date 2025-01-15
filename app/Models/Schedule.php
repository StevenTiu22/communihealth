<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'appointment_id',
        'date',
        'scheduled_time',
        'time_in',
        'time_out'
    ];

    protected $casts = [
        'date' => 'date',
        'scheduled_time' => 'datetime',
        'time_in' => 'datetime',
        'time_out' => 'datetime'
    ];

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }
}
