<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('vitals', function (Blueprint $table) {
        $table->id();
        $table->foreignId('patient_id')->constrained()->onDelete('cascade');
        
        // Adjusted precision and scale for each field
        $table->float('body_temperature', 4, 2); // 5 total digits, 2 after decimal
        $table->float('systolic_pressure', 5, 2); // For the systolic value
        $table->float('diastolic_pressure', 5, 2); // For the diastolic value
        $table->float('respiratory_rate', 5, 2); // Precision: 5 digits (example: 30.00)
        $table->float('weight', 5, 2);           // Precision: 6 digits (example: 250.00 kg)
        $table->float('height', 5, 2);           // Precision: 5 digits (example: 200.00 cm)
        $table->float('pulse_rate', 5, 2);       // Precision: 5 digits (example: 120.00 bpm)
        
        $table->timestamps();
    });
}



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vitals');
    }
};
