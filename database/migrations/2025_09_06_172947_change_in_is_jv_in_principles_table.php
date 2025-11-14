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
        Schema::table('principles', function (Blueprint $table) {
            $table->renameColumn('is_jv', 'venture_type');
        });

        DB::statement("ALTER TABLE principles CHANGE COLUMN venture_type venture_type ENUM('JV', 'SPV', 'Stand Alone') DEFAULT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('principles', function (Blueprint $table) {
            $table->renameColumn('venture_type', 'is_jv');
        });

        DB::statement("ALTER TABLE principles CHANGE COLUMN is_jv is_jv ENUM('Yes', 'No') DEFAULT NULL");
    }
};
