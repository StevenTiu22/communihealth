<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

class Medicine extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'name',
        'generic_name',
        'manufacturer',
        'description',
        'tracking_number',
        'delivery_date',
        'manufactured_date',
        'expiry_date',
        'num_of_boxes',
        'qty_per_boxes',
        'unit_of_measure',
        'stock_level',
        'source'
    ];

    protected $casts = [
        'delivery_date' => 'datetime:Y-m-d',
        'manufactured_date' => 'datetime:Y-m-d',
        'expiry_date' => 'datetime:Y-m-d',
        'created_at' => 'datetime:Y-m-d h:i:s A',
        'updated_at' => 'datetime:Y-m-d h:i:s A',
        'deleted_at' => 'datetime:Y-m-d h:i:s A'
    ];

    // Relationships
    public function category(): BelongsTo
    {
        return $this->belongsTo(MedicineCategory::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(MedicineTransaction::class);
    }

    // Accessors and mutators
    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucwords($value),
            set: fn ($value) => strtolower($value)
        );
    }

    protected function genericName(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucwords($value),
            set: fn ($value) => strtolower($value)
        );
    }

    protected function manufacturer(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucwords($value),
            set: fn ($value) => strtolower($value)
        );
    }

    protected function source(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucwords($value),
            set: fn ($value) => strtolower($value)
        );
    }

    // Methods
    public function expired(): bool
    {
        return $this->expiry_date < Carbon::now();
    }

    public function scopeExpired($query): Builder
    {
        return $query->where('expiry_date', '<', Carbon::now());
    }
}
