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
        Schema::table('user_installments', function (Blueprint $table) {
            $table->integer('transaction_id')->nullable();
            $table->integer('purchase_id');
            $table->dropColumn('payment_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_installments', function (Blueprint $table) {
            $table->dropColumn('transaction_id');
            $table->dropColumn('purchase_id');
            $table->integer('payment_id');
        });
    }
};
