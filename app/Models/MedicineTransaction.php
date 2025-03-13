<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MedicineTransaction extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'medicine_id',
        'bhw_id',
        'patient_id',
        'transaction_date',
        'transaction_time',
        'reference_number',
        'previous_stock_level',
        'quantity'
    ];

    protected $casts = [
        'transaction_date' => 'date'
    ];

    // Relationships
    public function medicine(): BelongsTo
    {
        return $this->belongsTo(Medicine::class);
    }

    public function bhw(): BelongsTo
    {
        return $this->belongsTo(User::class, 'bhw_id');
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    // Helper method for reverting stock
    public function revertStock(): void
    {
        $this->medicine->updateStock($this->quantity, 'in');
    }
}
