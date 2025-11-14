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
            $table->string('bond_number')->after('pan_no')->nullable();
        });
        Schema::table('performance_bonds', function (Blueprint $table) {
            $table->string('bond_number')->after('code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bid_bonds', function (Blueprint $table) {
            $table->dropColumn('bond_number');
        });
        Schema::table('performance_bonds', function (Blueprint $table) {
            $table->dropColumn('bond_number');
        });
    }
};
