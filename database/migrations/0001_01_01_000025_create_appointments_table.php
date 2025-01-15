<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->restrictOnDelete();
            $table->foreignId('bhw_id')->constrained('users')->restrictOnDelete();
            $table->foreignId('doctor_id')->nullable()->constrained('users')->restrictOnDelete();
            $table->foreignId('appointment_type_id')->constrained('appointment_types');
            $table->foreignId('treatment_record_id')->nullable()->constrained('treatment_records')->nullOnDelete();
            $table->foreignId('vital_signs_id')->nullable()->constrained('vital_signs')->nullOnDelete();
            $table->date('appointment_date');
            $table->timestamp('time_in')->nullable();
            $table->timestamp('time_out')->nullable();
            $table->text('chief_complaint');
            $table->text('remarks')->nullable();
            $table->tinyInteger('is_cancelled')->default(0);
            $table->text('cancellation_reason')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('appointment_date');
            $table->index('is_cancelled');
            $table->index('time_in');
            $table->index('time_out');
            $table->index(['patient_id', 'appointment_date']);
            $table->index(['bhw_id', 'appointment_date']);
            $table->index(['doctor_id', 'appointment_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
