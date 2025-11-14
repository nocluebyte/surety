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
        DB::statement("ALTER TABLE proposal_banking_limits CHANGE `sanctioned_amount` `sanctioned_amount` DECIMAL(18, 0) UNSIGNED NULL DEFAULT NULL");
        DB::statement("ALTER TABLE proposal_banking_limits CHANGE `unutilized_limit` `unutilized_limit` DECIMAL(18, 0) UNSIGNED NULL DEFAULT NULL");
        DB::statement("ALTER TABLE proposal_banking_limits CHANGE `commission_on_pg` `commission_on_pg` DECIMAL(18, 0) UNSIGNED NULL DEFAULT NULL");
        DB::statement("ALTER TABLE proposal_banking_limits CHANGE `commission_on_fg` `commission_on_fg` DECIMAL(18, 0) UNSIGNED NULL DEFAULT NULL");
        DB::statement("ALTER TABLE proposal_banking_limits CHANGE `margin_collateral` `margin_collateral` DECIMAL(18, 0) UNSIGNED NULL DEFAULT NULL");

        DB::statement("ALTER TABLE proposal_banking_limits CHANGE `proposal_id` `proposal_id` BIGINT UNSIGNED NULL DEFAULT NULL");
        DB::statement("ALTER TABLE proposal_banking_limits CHANGE `banking_category_id` `banking_category_id` BIGINT UNSIGNED NULL DEFAULT NULL");
        DB::statement("ALTER TABLE proposal_banking_limits CHANGE `facility_type_id` `facility_type_id` BIGINT UNSIGNED NULL DEFAULT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proposal_banking_limits', function (Blueprint $table) {
            //
        });
    }
};
