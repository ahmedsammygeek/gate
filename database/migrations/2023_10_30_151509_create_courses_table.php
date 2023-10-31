<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('category_id');
            $table->integer('university_id');
            $table->longText('title');
            $table->longText('subtitle');
            $table->longText('content');
            $table->text('image');
            $table->longText('curriculum');
            $table->integer('trainer_id');
            $table->double('reviews');
            $table->double('price');
            $table->double('price_after_discount')->nullable();
            $table->double('discount_percentage')->nullable();
            $table->date('discount_end_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
