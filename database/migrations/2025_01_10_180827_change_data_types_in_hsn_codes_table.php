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
            $table->unsignedDecimal('cgst', 16, 2)->nullable()->change();
            $table->unsignedDecimal('sgst', 16, 2)->nullable()->change();
            $table->unsignedDecimal('gst', 16, 2)->nullable()->change();
            $table->unsignedDecimal('igst', 16, 2)->nullable()->change();
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
