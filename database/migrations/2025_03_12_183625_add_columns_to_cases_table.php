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
        Schema::table('cases', function (Blueprint $table) {
            $table->integer('contractor_id')->nullable()->after('casesable_id');
            $table->integer('beneficiary_id')->nullable()->after('contractor_id');
            $table->integer('proposal_id')->nullable()->after('beneficiary_id');
            $table->integer('tender_id')->nullable()->after('proposal_id');
            $table->integer('bond_type_id')->nullable()->after('tender_id');
            $table->date('bond_start_date')->nullable()->after('bond_type_id');
            $table->date('bond_end_date')->nullable()->after('bond_start_date');
            $table->integer('bond_period')->nullable()->after('bond_end_date');
            $table->integer('bond_value')->nullable()->after('bond_period');
            $table->integer('contract_value')->nullable()->after('bond_value');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cases', function (Blueprint $table) {
            $table->dropColumn('contractor_id');
            $table->dropColumn('beneficiary_id');
            $table->dropColumn('proposal_id');
            $table->dropColumn('tender_id');
            $table->dropColumn('bond_type_id');
            $table->dropColumn('bond_start_date');
            $table->dropColumn('bond_end_date');
            $table->dropColumn('bond_period');
            $table->dropColumn('bond_value');
            $table->dropColumn('contract_value');
        });
    }
};
