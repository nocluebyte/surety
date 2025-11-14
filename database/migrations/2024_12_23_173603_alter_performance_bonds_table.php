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
        DB::statement("ALTER TABLE performance_bonds CHANGE `contractor_id` `contractor_id` INT(11) NULL DEFAULT NULL");
        DB::statement("ALTER TABLE performance_bonds CHANGE `contact_person_designation` `contact_person_designation` INT(11) NULL DEFAULT NULL");
        DB::statement("ALTER TABLE performance_bonds CHANGE `type_of_entity` `type_of_entity` INT(11) NULL DEFAULT NULL");
        DB::statement("ALTER TABLE performance_bonds CHANGE `chairman_designation` `chairman_designation` INT(11) NULL DEFAULT NULL");
        DB::statement("ALTER TABLE performance_bonds CHANGE `beneficiary_id` `beneficiary_id` INT(11) NULL DEFAULT NULL");
        DB::statement("ALTER TABLE performance_bonds CHANGE `contract_value_of_project` `contract_value_of_project` INT(11) NULL DEFAULT NULL");
        DB::statement("ALTER TABLE performance_bonds CHANGE `period_of_contract` `period_of_contract` INT(11) NULL DEFAULT NULL");
        DB::statement("ALTER TABLE performance_bonds CHANGE `tender_id` `tender_id` INT(11) NULL DEFAULT NULL");
        DB::statement("ALTER TABLE performance_bonds CHANGE `type_of_bond` `type_of_bond` INT(11) NULL DEFAULT NULL");
        DB::statement("ALTER TABLE performance_bonds CHANGE `bond_value` `bond_value` INT(11) NULL DEFAULT NULL");
        DB::statement("ALTER TABLE performance_bonds CHANGE `bond_period` `bond_period` INT(11) NULL DEFAULT NULL");
        //
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
