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
        Schema::create('disease_counts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('disease_id')->constrained('diseases')->restrictOnDelete();
            $table->foreignId('address_id')->constrained('addresses')->restrictOnDelete();
            $table->unsignedBigInteger('count');
            $table->unsignedBigInteger('active_cases');
            $table->unsignedBigInteger('recovered_cases');
            $table->unsignedBigInteger('death_cases');
            $table->date('date');
            $table->timestamps();

            $table->index('date');
            $table->index(['disease_id', 'date']);
            $table->index(['address_id', 'date']);
            $table->index(['disease_id', 'address_id', 'date'], 'unique_disease_location_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disease_counts');
    }
};
