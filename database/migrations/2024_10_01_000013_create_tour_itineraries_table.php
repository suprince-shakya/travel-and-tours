<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tour_itineraries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_id')->constrained('tours')->cascadeOnDelete();
            $table->integer('day');
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('activities')->nullable();
            $table->text('meals_included')->nullable();
            $table->text('accommodation')->nullable();
            $table->timestamps();

            $table->index('tour_id');
            $table->index('day');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tour_itineraries');
    }
};
