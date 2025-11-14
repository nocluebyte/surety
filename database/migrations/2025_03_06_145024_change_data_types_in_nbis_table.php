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
        Schema::table('nbis', function (Blueprint $table) {
            $table->unsignedDecimal('cash_margin_if_applicable', 18, 0)->nullable()->change();
            $table->unsignedDecimal('rate', 18, 0)->nullable()->change();
            $table->unsignedDecimal('cgst', 18, 0)->nullable()->change();
            $table->unsignedDecimal('cgst_amount', 18, 0)->nullable()->change();
            $table->unsignedDecimal('sgst', 18, 0)->nullable()->change();
            $table->unsignedDecimal('sgst_amount', 18, 0)->nullable()->change();
            $table->unsignedDecimal('igst', 18, 0)->nullable()->change();
            $table->unsignedDecimal('gst_amount', 18, 0)->nullable()->change();
            $table->unsignedDecimal('gross_premium', 18, 0)->nullable()->change();
            $table->unsignedDecimal('total_premium_including_stamp_duty', 18, 0)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nbis', function (Blueprint $table) {
            //
        });
    }
};
