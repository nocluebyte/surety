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
        Schema::rename('beneficiary_trade_sectors','proposal_beneficiary_trade_sectors');
        Schema::table('proposal_beneficiary_trade_sectors', function (Blueprint $table) {
            $table->renameColumn('beneficiary_id','proposalbeneficiarytradesectorsable_id');
            $table->string('proposalbeneficiarytradesectorsable_type')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proposal_beneficiary_trade_sectors', function (Blueprint $table) {
            //
        });
    }
};
