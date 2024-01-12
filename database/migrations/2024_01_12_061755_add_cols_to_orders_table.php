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
        Schema::table('orders', function (Blueprint $table) {
            $table->tinyInteger('is_paid')->default(0);
            $table->longText('response_data')->nullable();
            $table->string('invoice_id')->nullable();
            $table->string('payment_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('is_paid');
            $table->dropColumn('response_data');
            $table->dropColumn('invoice_id');
            $table->dropColumn('payment_id');
        });
    }
};
