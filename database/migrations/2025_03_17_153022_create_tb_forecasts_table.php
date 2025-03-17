<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations for ARIMA-specific TB forecast models
     */
    public function up(): void
    {
        Schema::create('tb_forecasts', function (Blueprint $table) {
            $table->id();
            $table->dateTime('forecast_date')->comment('Date when forecast was generated');
            $table->date('target_date')->comment('Future date being forecasted');
            $table->decimal('predicted_count', 10, 2)->comment('Predicted number of TB cases');
            $table->decimal('lower_bound', 10, 2)->comment('Lower bound of 95% confidence interval');
            $table->decimal('upper_bound', 10, 2)->comment('Upper bound of 95% confidence interval');
            $table->decimal('standard_error', 10, 4)->nullable()->comment('Standard error of the forecast');
            $table->string('model_version', 50)->nullable()->comment('Version of the forecasting model used');
            $table->timestamps();

            $table->index('forecast_date');
            $table->index('target_date');
            $table->unique(['forecast_date', 'target_date']);
        });

        Schema::create('arima_model_versions', function (Blueprint $table) {
            $table->id();
            $table->date('version_date')->comment('Version date in YYYY-MM-DD format');
            $table->dateTime('training_date')->comment('When the model was last trained');
            $table->date('last_data_date')->comment('Date of the last observation used in training');
            $table->unsignedTinyInteger('order_p')->comment('AR order parameter');
            $table->unsignedTinyInteger('order_d')->comment('Difference order parameter');
            $table->unsignedTinyInteger('order_q')->comment('MA order parameter');
            $table->decimal('aic', 12, 4)->nullable()->comment('Akaike Information Criterion');
            $table->decimal('bic', 12, 4)->nullable()->comment('Bayesian Information Criterion');
            $table->decimal('mse', 12, 4)->nullable()->comment('Mean Squared Error on training data');
            $table->string('file_path', 255)->comment('Path to the saved model file (arima_model-YYYY-MM-DD.pkl)');
            $table->text('notes')->nullable()->comment('Additional information about this model version');
            $table->timestamps();

            $table->index('version_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_forecasts');
        Schema::dropIfExists('arima_model_versions');
    }
};
