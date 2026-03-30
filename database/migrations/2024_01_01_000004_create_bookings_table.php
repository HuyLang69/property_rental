<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();       // the guest
            $table->foreignId('listing_id')->constrained()->cascadeOnDelete();

            $table->date('check_in');
            $table->date('check_out');
            $table->unsignedTinyInteger('guests');

            // Snapshot of price at time of booking (prices can change later)
            $table->unsignedInteger('price_per_night');     // in cents
            $table->unsignedInteger('cleaning_fee');        // in cents
            $table->unsignedInteger('service_fee');         // in cents
            $table->unsignedInteger('total');               // in cents

            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};