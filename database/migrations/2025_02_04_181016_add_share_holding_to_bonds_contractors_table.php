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
        Schema::table('bid_bond_contractors', function (Blueprint $table) {
            $table->integer('share_holding')->nullable()->after('spare_capacity');
        });
        Schema::table('performance_bond_contractors', function (Blueprint $table) {
            $table->integer('share_holding')->nullable()->after('spare_capacity');
        });
        Schema::table('proposal_contractors', function (Blueprint $table) {
            $table->integer('share_holding')->nullable()->after('spare_capacity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bid_bond_contractors', function (Blueprint $table) {
            $table->dropColumn('share_holding');    
        });
        Schema::table('performance_bond_contractors', function (Blueprint $table) {
            $table->dropColumn('share_holding');    
        });
        Schema::table('proposal_contractors', function (Blueprint $table) {
            $table->dropColumn('share_holding');    
        });
    }
};
