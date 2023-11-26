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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->text('image')->nullable();
            $table->integer('user_id');
            $table->integer('purchase_id');
            $table->double('amount');
            $table->string('payment_method');
            $table->text('payment_id')->comment('the payment id comes from the payment getaway')->nullable();
            $table->string('invoice_id')->nullable();
            $table->dateTime('payment_date');
            $table->integer('added_by');
            $table->json('payment_response')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
