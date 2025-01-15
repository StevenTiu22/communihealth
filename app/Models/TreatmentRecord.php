<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
<<<<<<< HEAD

class TreatmentRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'schedule_id',
        'assessment',
        'diagnosis',
        'treatment',
        'medication'
    ];

    // Relationships
    public function schedule() : BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }
}
=======
use Illuminate\Database\Eloquent\SoftDeletes;

class TreatmentRecord extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'patient_id',
        'diagnosis',
        'treatment',
        'notes',
        'treatment_date',
    ];

    protected $casts = [
        'treatment_date' => 'datetime',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
} 
>>>>>>> 6e27fc8f819ab12cb9a87b13b18e6246c488fc80
