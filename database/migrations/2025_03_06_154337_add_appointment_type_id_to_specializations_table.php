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
        Schema::table('specializations', function (Blueprint $table) {
            $table->foreignId('appointment_type_id')
                ->nullable()
                ->after('name')
                ->constrained('appointment_types')
                ->nullOnDelete();
            $table->index('appointment_type_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('specializations', function (Blueprint $table) {
            $table->dropForeign(['appointment_type_id']);
            $table->dropIndex(['appointment_type_id']);
            $table->dropColumn('appointment_type_id');
        });
    }
};
