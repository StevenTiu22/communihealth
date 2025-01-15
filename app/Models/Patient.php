<?php

namespace App\Models;

<<<<<<< HEAD
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
=======
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
>>>>>>> 6e27fc8f819ab12cb9a87b13b18e6246c488fc80
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
<<<<<<< HEAD
        'gender',
        'contact_number',
        'birth_date',
        'is_4ps',
        'is_NHTS',
        'profile_photo_path'
    ];

    // Relationships
    public function schedules() : HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    public function addresses() : BelongsToMany
    {
        return $this->belongsToMany(Address::class, $table='patient_addresses')
                    ->withTimestamps();
    }

    public function parents() : BelongsToMany
    {
        return $this->belongsToMany(ParentInfo::class, $table="patient_has_parents");
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
=======
        'sex',
        'birthdate',
        'is_4ps',
        'is_NHTS',
        'contact_num',
        'email',
    ];

    protected $casts = [
        'birthdate' => 'date',
        'is_4ps' => 'boolean',
        'is_NHTS' => 'boolean',
    ];

    public function treatmentRecords(): HasMany
    {
        return $this->hasMany(TreatmentRecord::class);
    }

    public function vitalSignRecords(): HasMany
    {
        return $this->hasMany(VitalSignRecord::class);
    }
} 
>>>>>>> 6e27fc8f819ab12cb9a87b13b18e6246c488fc80
