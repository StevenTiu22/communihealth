<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Disease extends Model
{
    protected $fillable = [
        'code',
        'name',
        'description',
        'type',
        'description',
        'risk_factors',
        'prevention',
        'treatment',
        'severity',
    ];

    public function treatmentRecord(): HasMany
    {
        return $this->hasMany(TreatmentRecord::class);
    }
}
