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
            $table->unsignedDecimal('cash_margin_amount', 18, 0)->nullable()->after('cash_margin_if_applicable');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nbis', function (Blueprint $table) {
            $table->dropColumn('cash_margin_amount');
        });
    }
};
