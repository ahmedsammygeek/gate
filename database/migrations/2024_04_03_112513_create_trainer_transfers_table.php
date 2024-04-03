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
        Schema::create('trainer_transfers', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('trainer_id');
            $table->integer('course_id');
            $table->double('amount');
            $table->tinyInteger('transfer_type')->comment('1 bank transfer 2 paypal , 3 vodafone cash');
            $table->text('image')->nullable();
            $table->text('comments')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainer_transfers');
    }
};
