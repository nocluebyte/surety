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
        Schema::table('bond_policies_issue', function (Blueprint $table) {
            //
        });

        DB::statement("ALTER TABLE bond_policies_issue CHANGE `proposal_id` `proposal_id` BIGINT UNSIGNED NULL DEFAULT NULL");
        DB::statement("ALTER TABLE bond_policies_issue CHANGE `beneficiary_id` `beneficiary_id` BIGINT UNSIGNED NULL DEFAULT NULL");
        DB::statement("ALTER TABLE bond_policies_issue CHANGE `contract_value` `contract_value` DECIMAL(18, 0) UNSIGNED NULL DEFAULT NULL");
        DB::statement("ALTER TABLE bond_policies_issue CHANGE `bond_value` `bond_value` DECIMAL(18, 0) UNSIGNED NULL DEFAULT NULL");
        DB::statement("ALTER TABLE bond_policies_issue CHANGE `bond_period` `bond_period` INT UNSIGNED NULL DEFAULT NULL");
        DB::statement("ALTER TABLE bond_policies_issue CHANGE `rate` `rate` DECIMAL(18, 0) UNSIGNED NULL DEFAULT NULL");
        DB::statement("ALTER TABLE bond_policies_issue CHANGE `net_premium` `net_premium` DECIMAL(18, 0) UNSIGNED NULL DEFAULT NULL");
        DB::statement("ALTER TABLE bond_policies_issue CHANGE `gst_amount` `gst_amount` DECIMAL(18, 0) UNSIGNED NULL DEFAULT NULL");
        DB::statement("ALTER TABLE bond_policies_issue CHANGE `gross_premium` `gross_premium` DECIMAL(18, 0) UNSIGNED NULL DEFAULT NULL");
        DB::statement("ALTER TABLE bond_policies_issue CHANGE `stamp_duty_charges` `stamp_duty_charges` DECIMAL(18, 0) UNSIGNED NULL DEFAULT NULL");
        DB::statement("ALTER TABLE bond_policies_issue CHANGE `total_premium` `total_premium` DECIMAL(18, 0) UNSIGNED NULL DEFAULT NULL");
        DB::statement("ALTER TABLE bond_policies_issue CHANGE `premium_amount` `premium_amount` DECIMAL(18, 0) UNSIGNED NULL DEFAULT NULL");
        DB::statement("ALTER TABLE bond_policies_issue CHANGE `additional_premium` `additional_premium` DECIMAL(18, 0) UNSIGNED NULL DEFAULT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE bond_policies_issue CHANGE `proposal_id` `proposal_id` INT DEFAULT 0");
        DB::statement("ALTER TABLE bond_policies_issue CHANGE `beneficiary_id` `beneficiary_id` INT DEFAULT 0");
        DB::statement("ALTER TABLE bond_policies_issue CHANGE `contract_value` `contract_value` INT DEFAULT 0");
        DB::statement("ALTER TABLE bond_policies_issue CHANGE `bond_value` `bond_value` INT DEFAULT 0");
        DB::statement("ALTER TABLE bond_policies_issue CHANGE `bond_period` `bond_period` INT DEFAULT 0");
        DB::statement("ALTER TABLE bond_policies_issue CHANGE `rate` `rate` INT DEFAULT 0");
        DB::statement("ALTER TABLE bond_policies_issue CHANGE `net_premium` `net_premium` INT DEFAULT 0");
        DB::statement("ALTER TABLE bond_policies_issue CHANGE `gst_amount` `gst_amount` INT DEFAULT 0");
        DB::statement("ALTER TABLE bond_policies_issue CHANGE `gross_premium` `gross_premium` INT DEFAULT 0");
        DB::statement("ALTER TABLE bond_policies_issue CHANGE `stamp_duty_charges` `stamp_duty_charges` INT DEFAULT 0");
        DB::statement("ALTER TABLE bond_policies_issue CHANGE `total_premium` `total_premium` INT DEFAULT 0");
        DB::statement("ALTER TABLE bond_policies_issue CHANGE `premium_amount` `premium_amount` DECIMAL(18, 0) DEFAULT 0");
        DB::statement("ALTER TABLE bond_policies_issue CHANGE `additional_premium` `additional_premium` DECIMAL(18, 0) DEFAULT 0");
    }
};
