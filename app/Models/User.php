<?php

namespace App\Models;

<<<<<<< HEAD
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
=======
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
>>>>>>> 6e27fc8f819ab12cb9a87b13b18e6246c488fc80
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

<<<<<<< HEAD
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasRoles;
    use Notifiable;
    use HasProfilePhoto;
=======
class User extends Authenticatable
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
>>>>>>> 6e27fc8f819ab12cb9a87b13b18e6246c488fc80
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
<<<<<<< HEAD
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
=======
        'name',
        'email',
        'password',
>>>>>>> 6e27fc8f819ab12cb9a87b13b18e6246c488fc80
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
<<<<<<< HEAD
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

    public function barangayOfficial() : HasOne
    {
        return $this->hasOne(BarangayOfficial::class);
    }

    public function doctor() : HasOne
    {
        return $this->hasOne(Doctor::class);
    }

    public function patient() : HasOne
    {
        return $this->hasOne(Patient::class);
    }

    // Accessors and mutators
    protected function firstName() : Attribute
    {
        return Attribute::make(
            set: fn ($value) => strtolower($value)
        );
    }

    protected function lastName() : Attribute
    {
        return Attribute::make(
            set: fn ($value) => strtolower($value)
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
                $middleName = $this->middle_name ? ' ' . $this->middle_name . ' ' : ' ';
                return $this->last_name . ', ' . $this->first_name . ' ' . $middleName;
            }
        );
    }

    protected function birthDate() : Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return Carbon::parse($value)->format('F d, Y');
            }
        );
    }

    /**
     * Check if the user is a barangay official.
     *
     * @return bool
     */
    public function isBarangayOfficial() : bool
    {
        return $this->barangayOfficial()->exists();
    }

    public function isActiveBarangayOfficial() : bool
    {
        return $this->barangayOfficial()?->isActive ?? false;
    }
=======
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
>>>>>>> 6e27fc8f819ab12cb9a87b13b18e6246c488fc80
}
