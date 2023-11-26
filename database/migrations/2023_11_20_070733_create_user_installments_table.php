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
        Schema::create('user_installments', function (Blueprint $table) {
            $table->id();
            $table->string('installment_number');
            $table->integer('user_id');
            $table->integer('course_id');
            $table->double('amount' , 8 , 2 );
            $table->date('due_date');
            $table->tinyInteger('status')->comment('1 paid 0 not paid yet')->default(0);
            $table->integer('payment_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_installments');
    }
};
