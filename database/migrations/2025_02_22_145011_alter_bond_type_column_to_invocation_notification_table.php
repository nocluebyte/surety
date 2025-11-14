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
        Schema::table('invocation_notification', function (Blueprint $table) {
            DB::statement("ALTER TABLE `invocation_notification` CHANGE `bond_type` `bond_type` INT(11) NULL DEFAULT NULL");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invocation_notification', function (Blueprint $table) {
            //
        });
    }
};
