<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();

            $table->string('studio_name')->default('Ashan Rumaiz');
            $table->text('bio')->nullable();
            $table->string('dispatch_email')->nullable();
            $table->string('phone')->nullable();
            $table->string('tax_id')->nullable();
            $table->string('address')->nullable();
            $table->text('artist_note')->nullable();
            $table->string('avatar_path')->nullable();

            $table->json('shooting_days')->nullable();
            $table->string('daily_start')->default('06:00');
            $table->string('daily_end')->default('19:30');
            $table->unsignedSmallInteger('turnaround_hours')->default(48);

            $table->boolean('notify_high_value')->default(true);
            $table->boolean('notify_contract_signed')->default(true);
            $table->boolean('notify_deposit')->default(true);
            $table->unsignedInteger('high_value_threshold')->default(3000);

            $table->unsignedTinyInteger('retainer_percent')->default(40);
            $table->unsignedSmallInteger('grace_hours')->default(72);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};

