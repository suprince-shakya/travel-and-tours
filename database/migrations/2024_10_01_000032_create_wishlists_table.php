<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wishlists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('tour_id')->nullable()->constrained('tours')->cascadeOnDelete();
            $table->string('destination_type')->nullable();
            $table->unsignedBigInteger('destination_id')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'tour_id']);
            $table->index('user_id');
            $table->index('tour_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wishlists');
    }
};
