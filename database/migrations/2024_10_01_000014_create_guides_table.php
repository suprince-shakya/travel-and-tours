<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guides', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('email')->unique();
            $table->string('phone', 20)->nullable();
            $table->string('photo')->nullable();
            $table->text('bio')->nullable();
            $table->integer('experience')->default(0);
            $table->string('languages')->nullable();
            $table->text('certifications')->nullable();
            $table->text('specialties')->nullable();
            $table->decimal('rating', 2, 1)->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('user_id');
            $table->index('status');
            $table->index('rating');
        });

        Schema::table('tours', function (Blueprint $table) {
            $table->foreign('guide_id')->references('id')->on('guides')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guides');
    }
};
