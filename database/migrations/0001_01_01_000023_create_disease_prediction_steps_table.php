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
        Schema::create('disease_prediction_steps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('disease_prediction')->constrained('disease_predictions')->restrictOnDelete();
            $table->unsignedInteger('step_number');
            $table->text('step_description')->nullable();
            $table->decimal('confidence_score', 5, 2)->default(0);
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disease_prediction_steps');
    }
};
