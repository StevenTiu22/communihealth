<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TreatmentRecord extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
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
