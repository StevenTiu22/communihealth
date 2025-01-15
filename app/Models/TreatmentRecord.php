<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
