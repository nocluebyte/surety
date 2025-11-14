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
            DB::statement("ALTER TABLE `principle_contractor_items` CHANGE `share_holding` `share_holding` DECIMAL(18,2) NULL DEFAULT NULL");
            ;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('performance_bonds', function (Blueprint $table) {
            //
        });
    }
};
