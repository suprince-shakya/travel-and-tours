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
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('tour_id')->constrained('tours')->cascadeOnDelete();
            $table->foreignId('booking_id')->nullable()->constrained('bookings')->nullOnDelete();
            $table->integer('rating');
            $table->string('title')->nullable();
            $table->text('review')->nullable();
            $table->text('images')->nullable();
            $table->string('video_url')->nullable();
            $table->boolean('verified')->default(false);
            $table->integer('helpful_votes')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('user_id');
            $table->index('tour_id');
            $table->index('booking_id');
            $table->index('rating');
            $table->index('status');
            $table->index('verified');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
