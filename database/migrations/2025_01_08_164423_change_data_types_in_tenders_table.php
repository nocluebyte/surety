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
        DB::statement("ALTER TABLE tenders CHANGE `period_of_bond` `period_of_bond` DECIMAL(18, 0) NULL DEFAULT NULL");
        DB::statement("ALTER TABLE tenders CHANGE `contract_value` `contract_value` DECIMAL(18, 0) NULL DEFAULT NULL");
        DB::statement("ALTER TABLE tenders CHANGE `bond_value` `bond_value` DECIMAL(18, 0) NULL DEFAULT NULL");

        DB::statement("ALTER TABLE tenders CHANGE `beneficiary_id` `beneficiary_id` BIGINT NULL DEFAULT NULL");
        DB::statement("ALTER TABLE tenders CHANGE `country_id` `country_id` BIGINT NULL DEFAULT NULL");
        DB::statement("ALTER TABLE tenders CHANGE `state_id` `state_id` BIGINT NULL DEFAULT NULL");
        DB::statement("ALTER TABLE tenders CHANGE `bond_type_id` `bond_type_id` BIGINT NULL DEFAULT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tenders', function (Blueprint $table) {
            //
        });
    }
};
