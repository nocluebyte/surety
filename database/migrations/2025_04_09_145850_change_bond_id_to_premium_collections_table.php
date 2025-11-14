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
        Schema::table('premium_collections', function (Blueprint $table) {
            DB::statement("ALTER TABLE `premium_collections` CHANGE `bond_id` `proposal_id` INT(11) NULL DEFAULT NULL;");
        });
        Schema::table('bond_progresses', function (Blueprint $table) {
            DB::statement("ALTER TABLE `bond_progresses` CHANGE `bond_id` `proposal_id` INT(11) NULL DEFAULT NULL;");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('premium_collections', function (Blueprint $table) {
            //
        });
    }
};
