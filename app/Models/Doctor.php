<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Doctor extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'license_number'
    ];

    // Relationships
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function specializations() : BelongsToMany
    {
        return $this->belongsToMany(Specialization::class, "doctor_specialization");
    }

    // Accessors and mutators
    /**
     * Get the total number of doctors.
     * @return Attribute
     */
    protected function totalDoctors() : Attribute
    {
        return Attribute::make(
            get: fn () => self::query()->count(),
        );
    }

    /**
     * Get the total number of specializations associated with the doctor.
     * @return Attribute
     */
    protected function totalSpecializations() : Attribute
    {
        return Attribute::make(
            get: fn () => $this->specializations()->count(),
        );
    }
}
