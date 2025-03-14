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
        Schema::table('bhw', function (Blueprint $table) {
            $table->renameColumn('barangay', 'assigned_barangay');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bhw', function (Blueprint $table) {
            $table->renameColumn('assigned_barangay', 'barangay');
        });
    }
};
