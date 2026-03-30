<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->cascadeOnDelete();  // one review per booking
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();     // the guest who wrote it
            $table->foreignId('listing_id')->constrained()->cascadeOnDelete();  // denormalised for easy querying

            $table->unsignedTinyInteger('rating');  // 1–5
            $table->text('comment');

            $table->timestamps();

            // A guest can only review a booking once
            $table->unique('booking_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};