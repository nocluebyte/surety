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
        \DB::statement("ALTER TABLE `years` CHANGE `is_default` `is_default` ENUM('Yes', 'No') NULL DEFAULT NULL");
        \DB::statement("ALTER TABLE `years` CHANGE `is_displayed` `is_displayed` ENUM('Yes', 'No') NULL DEFAULT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('years', function (Blueprint $table) {
            //
        });
    }
};
