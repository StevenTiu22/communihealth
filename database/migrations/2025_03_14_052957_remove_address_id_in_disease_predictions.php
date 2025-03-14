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
        Schema::table('disease_predictions', function (Blueprint $table) {
            // First drop the foreign key constraint
            $table->dropForeign('disease_predictions_address_id_foreign');

            // Then drop the column
            $table->dropColumn('address_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('disease_predictions', function (Blueprint $table) {
            // Add the column back
            $table->unsignedBigInteger('address_id')->nullable();

            // Re-add the foreign key constraint
            $table->foreign('address_id')
                ->references('id')
                ->on('addresses')
                ->onDelete('set null');
        });
    }
};
