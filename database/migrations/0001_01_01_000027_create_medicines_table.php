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
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('medicine_categories')->restrictOnDelete();
            $table->string('name');
            $table->string('generic_name');
            $table->string('manufacturer');
            $table->mediumText('description');
            $table->string('tracking_number')->unique();
            $table->date('delivery_date');
            $table->date('manufactured_date');
            $table->date('expiry_date');
            $table->integer('num_of_boxes');
            $table->integer('qty_per_boxes');
            $table->string('unit_of_measure', 10);
            $table->integer('stock_level');
            $table->string('source')->default('San Juan City Government');
            $table->softDeletes();
            $table->timestamps();

            $table->index(['name', 'category_id']);
            $table->index(['generic_name', 'category_id']);
            $table->index(['name', 'manufacturer']);
            $table->index('manufacturer');
            $table->index('tracking_number');
            $table->index('delivery_date');
            $table->index('expiry_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};
