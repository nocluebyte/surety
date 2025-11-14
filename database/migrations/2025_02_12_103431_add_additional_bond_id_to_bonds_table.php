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
            $table->integer('additional_bond_id')->after('proposal_id')->nullable();
        });
        Schema::table('maintenance_bonds', function (Blueprint $table) {
            $table->integer('additional_bond_id')->after('proposal_id')->nullable();
        });
        Schema::table('performance_bonds', function (Blueprint $table) {
            $table->integer('additional_bond_id')->after('proposal_id')->nullable();
        });
        Schema::table('retention_bonds', function (Blueprint $table) {
            $table->integer('additional_bond_id')->after('proposal_id')->nullable();
        });
        Schema::table('advance_payment_bonds', function (Blueprint $table) {
            $table->integer('additional_bond_id')->after('proposal_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bid_bonds', function (Blueprint $table) {
            $table->dropColumn('additional_bond_id');
        });
        Schema::table('maintenance_bonds', function (Blueprint $table) {
            $table->dropColumn('additional_bond_id');
        });
        Schema::table('performance_bonds', function (Blueprint $table) {
            $table->dropColumn('additional_bond_id');
        });
        Schema::table('retention_bonds', function (Blueprint $table) {
            $table->dropColumn('additional_bond_id');
        });
        Schema::table('advance_payment_bonds', function (Blueprint $table) {
            $table->dropColumn('additional_bond_id');
        });
    }
};
