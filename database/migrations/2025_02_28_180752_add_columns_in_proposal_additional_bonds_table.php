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
        Schema::table('proposal_additional_bonds', function (Blueprint $table) {
            $table->date('additional_bond_issued_date')->nullable()->after('additional_bond_id');
            $table->date('additional_bond_start_date')->nullable()->after('additional_bond_issued_date');
            $table->date('additional_bond_end_date')->nullable()->after('additional_bond_start_date');
            $table->unsignedBigInteger('additional_bond_period')->nullable()->after('additional_bond_end_date');
            $table->unsignedInteger('additional_bond_period_year')->nullable()->after('additional_bond_period');
            $table->unsignedInteger('additional_bond_period_month')->nullable()->after('additional_bond_period_year');
            $table->unsignedInteger('additional_bond_period_days')->nullable()->after('additional_bond_period_month');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proposal_additional_bonds', function (Blueprint $table) {
            $table->dropColumn(['additional_bond_issued_date', 'additional_bond_start_date', 'additional_bond_end_date', 'additional_bond_period', 'additional_bond_period_year', 'additional_bond_period_month', 'additional_bond_period_days']);
        });
    }
};
