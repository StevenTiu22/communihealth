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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->tinyInteger('sex');
            $table->date('birth_date');
            $table->tinyInteger('is_4ps');
            $table->tinyInteger('is_NHTS');
            $table->string('contact_number', 13);
            $table->string('profile_photo_path', 2048)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['last_name', 'first_name', 'middle_name']);
            $table->index('birth_date');
            $table->index('is_4ps');
            $table->index('is_NHTS');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
