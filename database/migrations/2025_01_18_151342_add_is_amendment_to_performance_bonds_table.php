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
        Schema::table('performance_bonds', function (Blueprint $table) {
            $table->tinyInteger('is_amendment')->default(0)->after('is_checklist_approved');
        });
        Schema::table('performance_bond_banking_limits', function (Blueprint $table) {
            $table->tinyInteger('is_amendment')->default(0)->after('margin_collateral');
        });
        Schema::table('performance_bond_beneficiaries', function (Blueprint $table) {
            $table->tinyInteger('is_amendment')->default(0)->after('project_horizon');
        });
        Schema::table('performance_bond_contractors', function (Blueprint $table) {
            $table->tinyInteger('is_amendment')->default(0)->after('remaining_cap');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('performance_bonds', function (Blueprint $table) {
            $table->dropColumn('is_amendment');
        });
        Schema::table('performance_bond_banking_limits', function (Blueprint $table) {
            $table->dropColumn('is_amendment');
        });
        Schema::table('performance_bond_beneficiaries', function (Blueprint $table) {
            $table->dropColumn('is_amendment');
        });
        Schema::table('performance_bond_contractors', function (Blueprint $table) {
            $table->dropColumn('is_amendment');
        });
    }
};
