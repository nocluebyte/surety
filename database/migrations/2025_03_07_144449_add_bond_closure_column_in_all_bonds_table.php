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
        Schema::table('bid_bonds', function (Blueprint $table) {
            $table->tinyInteger('bond_closure')->default(0)->after('is_amendment');
        });

        Schema::table('maintenance_bonds', function (Blueprint $table) {
            $table->tinyInteger('bond_closure')->default(0)->after('is_amendment');
        });

        Schema::table('performance_bonds', function (Blueprint $table) {
            $table->tinyInteger('bond_closure')->default(0)->after('is_amendment');
        });

        Schema::table('retention_bonds', function (Blueprint $table) {
            $table->tinyInteger('bond_closure')->default(0)->after('is_amendment');
        });

        Schema::table('advance_payment_bonds', function (Blueprint $table) {
            $table->tinyInteger('bond_closure')->default(0)->after('is_amendment');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bid_bonds', function (Blueprint $table) {
            $table->dropColumn('bond_closure');
        });

        Schema::table('maintenance_bonds', function (Blueprint $table) {
            $table->dropColumn('bond_closure');
        });

        Schema::table('performance_bonds', function (Blueprint $table) {
            $table->dropColumn('bond_closure');
        });

        Schema::table('retention_bonds', function (Blueprint $table) {
            $table->dropColumn('bond_closure');
        });

        Schema::table('advance_payment_bonds', function (Blueprint $table) {
            $table->dropColumn('bond_closure');
        });
    }
};
