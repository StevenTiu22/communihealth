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
        Schema::table('appointment_types', function (Blueprint $table) {
            $table->foreignId('specialization_id')
                ->nullable()
                ->after('name')
                ->constrained('specializations')
                ->nullOnDelete();
            $table->index('specialization_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointment_types', function (Blueprint $table) {
            $table->dropForeign(['specialization_id']);
            $table->dropIndex(['specialization_id']);
            $table->dropColumn('specialization_id');
        });
    }
};
