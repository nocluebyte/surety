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
            $table->string('bond_cancel')->nullable()->after('is_nbi');
        });

        Schema::table('maintenance_bonds', function (Blueprint $table) {
            $table->string('bond_cancel')->nullable()->after('is_nbi');
        });

        Schema::table('performance_bonds', function (Blueprint $table) {
            $table->string('bond_cancel')->nullable()->after('is_nbi');
        });

        Schema::table('retention_bonds', function (Blueprint $table) {
            $table->string('bond_cancel')->nullable()->after('is_nbi');
        });

        Schema::table('advance_payment_bonds', function (Blueprint $table) {
            $table->string('bond_cancel')->nullable()->after('is_nbi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bid_bonds', function (Blueprint $table) {
            $table->dropColumn('bond_cancel');
        });

        Schema::table('maintenance_bonds', function (Blueprint $table) {
            $table->dropColumn('bond_cancel');
        });

        Schema::table('performance_bonds', function (Blueprint $table) {
            $table->dropColumn('bond_cancel');
        });

        Schema::table('retention_bonds', function (Blueprint $table) {
            $table->dropColumn('bond_cancel');
        });

        Schema::table('advance_payment_bonds', function (Blueprint $table) {
            $table->dropColumn('bond_cancel');
        });
    }
};
