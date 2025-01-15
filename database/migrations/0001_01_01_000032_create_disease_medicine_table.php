<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('disease_medicine', function (Blueprint $table) {
            $table->id();
            $table->foreignId('disease_id')->constrained('diseases')->restrictOnDelete();
            $table->foreignId('medicine_id')->constrained('medicines')->restrictOnDelete();
            $table->enum('treatment_line', ['primary', 'secondary', 'tertiary', 'supplementary'])->default('primary');
            $table->string('dosage');
            $table->string('frequency');
            $table->string('duration')->nullable();
            $table->text('special_instructions')->nullable();
            $table->text('contraindications')->nullable();
            $table->text('side_effects')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['disease_id', 'medicine_id', 'treatment_line']);
            $table->index(['disease_id', 'treatment_line']);
            $table->index(['medicine_id', 'treatment_line']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disease_medicine');
    }
};
