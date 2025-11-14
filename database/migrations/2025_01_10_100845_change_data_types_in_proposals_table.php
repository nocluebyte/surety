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
        DB::statement("ALTER TABLE proposals CHANGE `shares` `shares` DECIMAL(18, 0) UNSIGNED NULL DEFAULT NULL");
        DB::statement("ALTER TABLE proposals CHANGE `networth` `networth` DECIMAL(18, 0) UNSIGNED NULL DEFAULT NULL");
        DB::statement("ALTER TABLE proposals CHANGE `contract_value_of_project` `contract_value_of_project` DECIMAL(18, 0) UNSIGNED NULL DEFAULT NULL");
        DB::statement("ALTER TABLE proposals CHANGE `bond_value` `bond_value` DECIMAL(18, 0) UNSIGNED NULL DEFAULT NULL");
        DB::statement("ALTER TABLE proposals CHANGE `amount_of_margin` `amount_of_margin` DECIMAL(18, 0) UNSIGNED NULL DEFAULT NULL");

        DB::statement("ALTER TABLE proposals CHANGE `chairman_designation` `chairman_designation` BIGINT UNSIGNED NULL DEFAULT NULL");
        DB::statement("ALTER TABLE proposals CHANGE `beneficiary_id` `beneficiary_id` BIGINT UNSIGNED NULL DEFAULT NULL");
        DB::statement("ALTER TABLE proposals CHANGE `period_tenor_of_contract` `period_tenor_of_contract` BIGINT UNSIGNED NULL DEFAULT NULL");
        DB::statement("ALTER TABLE proposals CHANGE `type_of_bond` `type_of_bond` BIGINT UNSIGNED NULL DEFAULT NULL");
        DB::statement("ALTER TABLE proposals CHANGE `bond_period` `bond_period` BIGINT UNSIGNED NULL DEFAULT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proposals', function (Blueprint $table) {
            //
        });
    }
};
