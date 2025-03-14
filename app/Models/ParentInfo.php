<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ParentInfo extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'philhealth_no',
        'status'
    ];

    // Relationships
    public function patients() : BelongsToMany
    {
        return $this->belongsToMany(Patient::class, 'patient_parent', 'parent_id', 'patient_id')
            ->withPivot('relationship')
            ->withTimestamps();
    }

    // Accessors and mutators
    protected function firstName() : Attribute
    {
        return Attribute::make(
            set: fn (string $value) => strtolower($value)
        );
    }

    protected function lastName() : Attribute
    {
        return Attribute::make(
            set: fn (string $value) => strtolower($value)
        );
    }

    protected function middleName() : Attribute
    {
        return Attribute::make(
            set: fn ($value) => $value ? strtolower($value) : ''
        );
    }
}
