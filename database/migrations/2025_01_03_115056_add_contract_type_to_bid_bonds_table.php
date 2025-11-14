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
            $table->string('contract_type')->nullable()->after('user_id');
            $table->integer('tender_id')->nullable()->after('contract_type');
            $table->integer('bond_value')->nullable()->after('tender_id');
            $table->integer('contractor_id')->nullable()->after('bond_value');
            $table->string('pan_no')->nullable()->after('contractor_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bid_bonds', function (Blueprint $table) {
            $table->dropColumn('contract_type');
            $table->dropColumn('tender_id');
            $table->dropColumn('bond_value');
            $table->dropColumn('contractor_id');
            $table->dropColumn('pan_no');
        });
    }
};
