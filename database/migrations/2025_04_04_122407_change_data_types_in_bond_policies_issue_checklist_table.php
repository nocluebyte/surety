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
        DB::statement("ALTER TABLE bond_policies_issue_checklist CHANGE `proposal_id` `proposal_id` BIGINT UNSIGNED NULL DEFAULT NULL");
        DB::statement("ALTER TABLE bond_policies_issue_checklist CHANGE `premium_amount` `premium_amount` DECIMAL(18, 0) UNSIGNED NULL DEFAULT NULL");
        DB::statement("ALTER TABLE bond_policies_issue_checklist CHANGE `fd_amount` `fd_amount` DECIMAL(18, 0) UNSIGNED NULL DEFAULT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bond_policies_issue_checklist', function (Blueprint $table) {
            $table->integer('proposal_id')->default(0)->change();
            $table->integer('premium_amount')->default(0)->change();
            $table->integer('fd_amount')->default(0)->change();
        });
    }
};
