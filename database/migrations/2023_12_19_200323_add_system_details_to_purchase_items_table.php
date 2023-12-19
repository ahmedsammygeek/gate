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
        Schema::table('purchase_items', function (Blueprint $table) {
            $table->text('system_details')->nullable();
            $table->tinyInteger('item_type')->comment('1 course , 2 package');
            $table->renameColumn('course_id', 'item_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchase_items', function (Blueprint $table) {
            $table->dropColumn('system_details');
            $table->dropColumn('item_type');
            $table->renameColumn('item_id' , 'course_id');
        });
    }
};
