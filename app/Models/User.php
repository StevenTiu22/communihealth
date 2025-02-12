<?php

namespace App\Models;

use App\Http\Requests\UserRequest;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory;
    use HasRoles;
    use LogsActivity;
    use Notifiable;
    use SoftDeletes;
    use HasProfilePhoto;
    use TwoFactorAuthenticatable;

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
        'password',
        'profile_photo_path',
        'last_login_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
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
            'birth_date' => 'date',
            'password' => 'hashed',
            'email_verified_at' => 'datetime',
        ];
    }
    protected static $recordEvents = [
        'created',
        'updated',
        'deleted',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::created(function ($user) {
            $user->roles()->detach();
        });
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

    // Scopes
    public function scopeVerifiedUser($query): Builder
    {
        return $query->whereNotNull('email_verified_at');
    }

    // Logging
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
