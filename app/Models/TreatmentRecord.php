<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class TreatmentRecord extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'disease_id',
        'assessment',
        'diagnosis',
        'treatment',
        'medication',
    ];

    // Relationships
    public function disease(): BelongsTo
    {
        return $this->belongsTo(Disease::class);
    }

    public function schedule(): HasOne
    {
        return $this->hasOne(Schedule::class);
    }
}
