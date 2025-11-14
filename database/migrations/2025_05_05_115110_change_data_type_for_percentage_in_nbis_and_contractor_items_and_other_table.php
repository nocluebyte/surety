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
            $table->unsignedDecimal('cash_margin_if_applicable', 4, 2)->nullable()->change();
            $table->unsignedDecimal('rate', 4, 2)->nullable()->change();
        });

        Schema::table('management_profiles', function (Blueprint $table) {
            $table->unsignedDecimal('experience', 8, 1)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nbis', function (Blueprint $table) {
            $table->unsignedDecimal('cash_margin_if_applicable', 18, 0)->nullable()->change();
            $table->unsignedDecimal('rate', 18, 0)->nullable()->change();
        });

        Schema::table('management_profiles', function (Blueprint $table) {
            $table->string('experience')->nullable()->change();
        });
    }
};
