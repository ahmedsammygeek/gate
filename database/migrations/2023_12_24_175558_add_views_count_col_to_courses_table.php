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
        Schema::table('courses', function (Blueprint $table) {
            $table->integer('views_count')->nullable();
            $table->integer('installments_count')->nullable();
            $table->integer('one_later_installment_count')->nullable();
            $table->integer('total_amount_count')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn('views_count');
            $table->dropColumn('installments_count');
            $table->dropColumn('one_later_installment_count');
            $table->dropColumn('total_amount_count');
        });
    }
};
