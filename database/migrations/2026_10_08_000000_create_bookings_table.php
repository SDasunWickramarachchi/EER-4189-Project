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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('client_name');
            $table->string('client_phone');
            $table->string('client_email');
            $table->date('session_date');
            $table->string('start_time')->nullable();
            $table->string('end_time')->nullable();
            $table->string('session_type'); // e.g., 'Weddings & Couples', 'Maternity', 'Newborn & Six Months', 'Events'
            $table->string('location');
            $table->string('status')->default('pending'); // 'pending', 'confirmed', 'awaiting_retainer', 'completed', 'cancelled'
            $table->string('lead_photographer')->default('Ashan Rumaiz (Principal)');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
