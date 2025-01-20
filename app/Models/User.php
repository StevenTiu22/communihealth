<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Jetstream\HasProfilePhoto;

class User extends Authenticatable
{
    use HasFactory;
    use SoftDeletes;
    use HasProfilePhoto;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'birth_date',
        'sex',
        'contact_no',
        'email',
        'username',
        'contact_number',
        'profile_photo_path',
        'user_type',
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'sex' => 'string',
            'birth_date' => 'date',
            'password' => 'hashed',
            'email_verified_at' => 'datetime',
            'user_type' => 'string',
        ];
    }

    // Relationships
    public function address() : MorphOne
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    public function barangayOfficial(): HasOne
    {
        return $this->hasOne(BarangayOfficial::class);
    }

    public function bhw(): HasOne
    {
        return $this->hasOne(BHW::class);
    }

    public function doctor(): HasOne
    {
        return $this->hasOne(Doctor::class);
    }

    // Accessors and mutators
    protected function firstName() : Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucfirst($value),
            set: fn ($value) => strtolower($value)
        );
    }

    protected function lastName() : Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucfirst($value),
            set: fn ($value) => strtolower($value)
        );
    }

    protected function middleName() : Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? ucfirst($value) : '',
            set: fn ($value) => $value ? strtolower($value) : ''
        );
    }

    protected function fullName() : Attribute
    {
        return Attribute::make(
            get: function () {
                $middle_initial = $this->middle_name ? $this->middle_name[0] . '.' : '';
                return "{$this->last_name}, {$this->first_name} {$middle_initial}";
            }
        );
    }

    protected function sex(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value === 0 ? 'male' : 'female',
            set: fn ($value) => $value === 'male' ? 0 : 1
        );
    }

    protected function birthDate(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('F j, Y'),
            set: fn ($value) => Carbon::parse($value)->format('Y-m-d')
        );
    }

    protected function contactNo(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => preg_replace('/^(\d{3})(\d{3})(\d{4})/', "($1) $2-$3", $value),
            set: fn ($value) => preg_replace('/\D/', '', $value)
        );
    }

    protected function userType(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => match($value) {
                0 => 'Barangay Official',
                1 => 'BHW',
                2 => 'Doctor',
            },
        );
    }
}
