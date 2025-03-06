<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppointmentType extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'specialization_id',
        'description',
        'duration_minutes'
    ];

    // Relationships
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function specialization(): BelongsTo
    {
        return $this->belongsTo(Specialization::class);
    }
}
