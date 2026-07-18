<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('code', 2)->unique();
            $table->string('phone_code', 10)->nullable();
            $table->string('flag')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('currency', 3)->nullable();
            $table->string('currency_symbol', 10)->nullable();
            $table->string('language', 50)->nullable();
            $table->string('timezone', 50)->nullable();
            $table->string('capital', 100)->nullable();
            $table->bigInteger('population')->nullable();
            $table->decimal('area', 15, 2)->nullable();
            $table->text('visa_info')->nullable();
            $table->string('best_season', 100)->nullable();
            $table->text('travel_tips')->nullable();
            $table->text('emergency_contacts')->nullable();
            $table->text('weather_info')->nullable();
            $table->boolean('status')->default(true);
            $table->boolean('featured')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
            $table->index('featured');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
