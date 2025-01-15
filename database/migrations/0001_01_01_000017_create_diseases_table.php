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
        Schema::create('diseases', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->enum('type', ['infectious', 'chronic', 'acute', 'mental', 'genetic', 'lifestyle', 'non-infectious', 'other'])->default('non-infectious');
            $table->text('description')->nullable();
            $table->text('risk_factors')->nullable();
            $table->text('prevention')->nullable();
            $table->text('treatment')->nullable();
            $table->enum('severity', ['mild', 'moderate', 'severe', 'critical'])->default('moderate');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['name', 'code']);
            $table->index('type');
            $table->index('severity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disease');
    }
};
