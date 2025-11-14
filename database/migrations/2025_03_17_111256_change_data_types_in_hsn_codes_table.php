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
        Schema::table('hsn_codes', function (Blueprint $table) {
            $table->unsignedDecimal('cgst', 18, 0)->nullable()->change();
            $table->unsignedDecimal('sgst', 18, 0)->nullable()->change();
            $table->unsignedDecimal('gst', 18, 0)->nullable()->change();
            $table->unsignedDecimal('igst', 18, 0)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hsn_codes', function (Blueprint $table) {
            //
        });
    }
};
