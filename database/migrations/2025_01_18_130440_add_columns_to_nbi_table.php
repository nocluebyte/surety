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
            $table->unsignedDecimal('cgst',18,2)->nullable()->after('hsn_code_id');
            $table->unsignedDecimal('cgst_amount',18,2)->nullable()->after('cgst');
            $table->unsignedDecimal('sgst',18,2)->nullable()->after('cgst_amount');
            $table->unsignedDecimal('sgst_amount',18,2)->nullable()->after('sgst');
            $table->unsignedDecimal('igst',18,2)->nullable()->after('sgst_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nbis', function (Blueprint $table) {
            $table->dropColumn(['cgst','cgst_amount','sgst','sgst_amount','igst']);
        });
    }
};
