<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // the host

            $table->string('title');
            $table->text('description');
            $table->enum('type', ['apartment', 'house', 'studio', 'villa', 'room']);

            // Location
            $table->string('city');
            $table->string('country');
            $table->string('address');

            // Details
            $table->unsignedTinyInteger('bedrooms');
            $table->unsignedTinyInteger('bathrooms');
            $table->unsignedTinyInteger('max_guests');

            // Pricing
            $table->unsignedInteger('price_per_night');     // stored in cents to avoid float issues
                                                            // e.g. $85.00 = 8500
            $table->unsignedInteger('cleaning_fee')->default(0);

            // Availability
            $table->boolean('is_available')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};