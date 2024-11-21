<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
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