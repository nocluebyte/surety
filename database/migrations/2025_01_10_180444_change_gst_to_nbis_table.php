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
        Schema::table('nbis', function (Blueprint $table) {
            DB::statement("ALTER TABLE `nbis` CHANGE `gst` `hsn_code_id` INT NULL DEFAULT NULL;");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nbis', function (Blueprint $table) {
            //
        });
    }
};
