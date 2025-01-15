<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class VitalSignRecord extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'patient_id',
        'weight',
        'height',
        'temperature',
        'systolic_bp',
        'diastolic_bp',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
} 