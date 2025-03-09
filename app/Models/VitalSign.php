<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VitalSign extends Model
{
    use HasFactory;

    protected $fillable = [
        'weight',
        'height',
        'diastolic',
        'systolic',
        'temperature'
    ];

    // Relationships
    public function appointment(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    // Accessors and mutators
    protected function blood_pressure() : Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->systolic && $this->diastolic ? $this->systolic . '/' . $this->diastolic : null;
            }
        );
    }
}
