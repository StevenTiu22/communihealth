<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'house_number',
        'street',
        'barangay',
        'city',
        'province',
        'region',
        'country'
    ];

    // Relationships
    public function addressable() : MorphTo
    {
        return $this->morphTo(__FUNCTION__, 'addressable_type', 'addressable_id');
    }

    // Accessors and mutators
    protected function street() : Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucwords($value),
            set: fn ($value) => strtolower($value)
        );
    }

    protected function barangay() : Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucwords($value),
            set: fn ($value) => strtolower($value)
        );
    }

    protected function city() : Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucwords($value),
            set: fn ($value) => strtolower($value)
        );
    }

    protected function fullAddress() : Attribute
    {
        return Attribute::make(
            get: function () {
                return "{$this->house_number} {$this->street}, {$this->barangay}, {$this->city}";
            }
        );
    }
}
