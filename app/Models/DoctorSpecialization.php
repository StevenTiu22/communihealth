<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DoctorSpecialization extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table = 'doctor_specialization';
    public $timestamps = true;
}
