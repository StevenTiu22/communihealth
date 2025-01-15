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
        Schema::create('disease_predictions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('disease_id')->constrained('diseases')->restrictOnDelete();
            $table->foreignId('address_id')->constrained('addresses')->restrictOnDelete();
            $table->unsignedBigInteger('prediction_count')->default(0);
            $table->date('prediction_date');
            $table->decimal('confidence_score', 5, 2)->default(0);
            $table->timestamp('created_at')->useCurrent();

            $table->index('disease_id');
            $table->index('prediction_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disease_predictions');
    }
};
