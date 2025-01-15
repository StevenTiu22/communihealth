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
        Schema::create('disease_symptom', function (Blueprint $table) {
            $table->id();
            $table->foreignId('disease_id')->constrained('diseases')->restrictOnDelete();
            $table->foreignId('symptom_id')->constrained('symptoms')->restrictOnDelete();
            $table->enum('frequency', ['always', 'often', 'sometimes', 'rarely'])->default('sometimes');
            $table->enum('severity', ['mild', 'moderate', 'severe', 'critical'])->default('moderate');
            $table->text('characteristics')->nullable();
            $table->text('onset_pattern')->nullable();
            $table->text('duration')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Prevent duplicate disease-symptom combinations
            $table->unique(['disease_id', 'symptom_id']);

            // Indexes for better query performance
            $table->index(['disease_id', 'frequency']);
            $table->index(['disease_id', 'severity']);
            $table->index(['symptom_id', 'frequency']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disease_symptom');
    }
};
