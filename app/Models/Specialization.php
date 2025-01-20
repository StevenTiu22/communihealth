<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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

    // Accessors and mutators
    protected function name() : Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucwords($value),
            set: fn ($value) => strtolower($value)
        );
    }
}
