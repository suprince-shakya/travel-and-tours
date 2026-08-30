<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tours', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->foreignId('country_id')->constrained('countries')->cascadeOnDelete();
            $table->foreignId('region_id')->nullable()->constrained('regions')->cascadeOnDelete();
            $table->foreignId('city_id')->nullable()->constrained('cities')->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('duration', 50);
            $table->string('difficulty', 20);
            $table->integer('max_elevation')->nullable();
            $table->decimal('price', 12, 2);
            $table->decimal('discount_price', 12, 2)->nullable();
            $table->string('currency', 3)->default('USD');
            $table->string('thumbnail')->nullable();
            $table->string('video_url')->nullable();
            $table->text('map_embed')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->longText('description');
            $table->longText('overview')->nullable();
            $table->text('highlights')->nullable();
            $table->text('included')->nullable();
            $table->text('excluded')->nullable();
            $table->text('accommodation')->nullable();
            $table->text('transportation')->nullable();
            $table->text('meals')->nullable();
            $table->text('fitness_level')->nullable();
            $table->text('packing_list')->nullable();
            $table->string('best_season')->nullable();
            $table->text('weather_info')->nullable();
            $table->string('languages')->nullable();
            $table->text('cancellation_policy')->nullable();
            $table->text('terms')->nullable();
            $table->unsignedBigInteger('guide_id')->nullable();
            $table->integer('max_group_size');
            $table->integer('remaining_seats');
            $table->date('available_from')->nullable();
            $table->date('available_to')->nullable();
            $table->boolean('status')->default(true);
            $table->boolean('featured')->default(false);
            $table->boolean('popular')->default(false);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->bigInteger('views')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index('category_id');
            $table->index('country_id');
            $table->index('region_id');
            $table->index('city_id');
            $table->index('status');
            $table->index('featured');
            $table->index('popular');
            $table->index('difficulty');
            $table->index('price');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tours');
    }
};
