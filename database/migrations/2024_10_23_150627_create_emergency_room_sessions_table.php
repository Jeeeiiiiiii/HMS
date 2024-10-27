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
        Schema::create('emergency_room_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('emergency_room_id')->constrained()->onDelete('cascade');
            $table->string('device_name');
            $table->string('browser_name');
            $table->timestamp('last_active_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emergency_room_sessions');
    }
};
