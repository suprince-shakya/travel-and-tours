<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hotel_rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')->constrained('hotels')->cascadeOnDelete();
            $table->string('room_type');
            $table->text('description')->nullable();
            $table->integer('max_guests')->default(1);
            $table->decimal('price_per_night', 12, 2);
            $table->string('currency', 3)->default('USD');
            $table->integer('total_rooms')->default(1);
            $table->integer('available_rooms')->default(1);
            $table->text('amenities')->nullable();
            $table->text('images')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();

            $table->index('hotel_id');
            $table->index('room_type');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hotel_rooms');
    }
};
