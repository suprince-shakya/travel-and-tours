<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('type', 20);
            $table->string('model')->nullable();
            $table->string('brand')->nullable();
            $table->integer('year')->nullable();
            $table->integer('capacity');
            $table->text('description')->nullable();
            $table->text('features')->nullable();
            $table->decimal('price_per_day', 12, 2);
            $table->string('currency', 3)->default('USD');
            $table->decimal('driver_price', 12, 2)->nullable();
            $table->string('image')->nullable();
            $table->text('gallery')->nullable();
            $table->string('fuel_type', 30)->nullable();
            $table->string('mileage', 30)->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('type');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
