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
        Schema::table('bid_bonds', function (Blueprint $table) {
            $table->tinyInteger('is_nbi')->default(0)->after('is_amendment');
        });
        Schema::table('performance_bonds', function (Blueprint $table) {
            $table->tinyInteger('is_nbi')->default(0)->after('is_amendment');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bid_bonds', function (Blueprint $table) {
            $table->dropColumn('is_nbi');
        });
        Schema::table('performance_bonds', function (Blueprint $table) {
            $table->dropColumn('is_nbi');
        });
    }
};
