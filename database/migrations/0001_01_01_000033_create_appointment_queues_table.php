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
        Schema::create('appointment_queues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id')->nullable()->constrained('appointments')->nullOnDelete();
            $table->integer('queue_number');
            $table->date('queue_date');
            $table->enum('queue_status', ['waiting', 'in progress', 'completed', 'no show', 'cancelled'])->default('waiting');
            $table->string('queue_type')->default('walk-in');
            $table->text('remarks')->nullable();
            $table->timestamp('called_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('queue_number');
            $table->index('queue_date');
            $table->index('queue_status');
            $table->index(['queue_date', 'queue_status']);
            $table->index(['queue_date', 'queue_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointment_queues');
    }
};
