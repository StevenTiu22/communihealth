<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Jetstream\HasProfilePhoto;

class Patient extends Model
{
    use HasFactory, SoftDeletes, HasProfilePhoto;

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'sex',
        'birth_date',
        'contact_number',
        'is_4ps',
        'is_NHTS',
        'profile_photo_path',
    ];

    protected $casts = [
        'birth_date' => 'datetime:Y-m-d',
        'is_4ps' => 'boolean',
        'is_NHTS' => 'boolean',
    ];

    // Relationships

    public function parents(): BelongsToMany
    {
        return $this->belongsToMany(ParentInfo::class, 'patient_parent', 'patient_id', 'parent_id')
            ->withPivot('relationship')
            ->withTimestamps();
    }

    public function address(): MorphOne
    {
        return $this->morphOne(Address::class, 'addressable');
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

    protected function fullName() : Attribute
    {
        return Attribute::make(
            get: function () {
                $middle = $this->middle_name ? ' ' . strtoupper($this->middle_name[0]) . '.' : '';
                return strtoupper($this->last_name) . ', ' . ucwords($this->first_name) . $middle;
            }
        );
    }

    protected function age() : Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->birth_date ? Carbon::parse($this->birth_date)->age : null;
            }
        );
    }
}
