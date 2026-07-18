<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tour_dates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_id')->constrained('tours')->cascadeOnDelete();
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('price', 12, 2)->nullable();
            $table->integer('available_seats');
            $table->boolean('status')->default(true);
            $table->timestamps();

            $table->index('tour_id');
            $table->index('start_date');
            $table->index('end_date');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tour_dates');
    }
};
