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
    Schema::table('er_orders', function (Blueprint $table) {
        // Adding the admitting_doctor column as a foreign key to the doctors table
        $table->foreignId('admitting_doctor')->nullable()->constrained('doctors')->onDelete('set null');
    });
}

public function down()
{
    Schema::table('er_orders', function (Blueprint $table) {
        // Dropping the admitting_doctor column if the migration is rolled back
        $table->dropColumn('admitting_doctor');
    });
}

};
