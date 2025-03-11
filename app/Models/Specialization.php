<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Specialization extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description'
    ];

    // Relationships
    public function doctors() : BelongsToMany
    {
        return $this->belongsToMany(Doctor::class, 'doctor_specialization')
            ->withTimestamps();
    }

    public function appointmentTypes(): HasMany
    {
        return $this->hasMany(AppointmentType::class);
    }

    // Accessors and mutators
    protected function name() : Attribute
    {
        return Attribute::make(
            set: fn ($value) => strtolower($value)
        );
    }
}
