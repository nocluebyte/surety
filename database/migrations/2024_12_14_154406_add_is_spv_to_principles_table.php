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
            $table->enum('is_spv', ['Yes', 'No'])->default('No')->after('pan_no');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('principles', function (Blueprint $table) {
            $table->dropColumn('is_spv');
        });
    }
};
