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
        Schema::table('trade_sector_items', function (Blueprint $table) {
            $table->unsignedBigInteger('contractor_fetch_reference_id')->nullable()->after('id');
        });

        Schema::table('proposal_beneficiary_trade_sectors', function (Blueprint $table) {
            $table->unsignedBigInteger('contractor_fetch_reference_id')->nullable()->after('id');
        });

        Schema::table('contact_details', function (Blueprint $table) {
            $table->unsignedBigInteger('contractor_fetch_reference_id')->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trade_sector_items', function (Blueprint $table) {
            $table->dropColumn('contractor_fetch_reference_id');
        });

        Schema::table('proposal_beneficiary_trade_sectors', function (Blueprint $table) {
            $table->dropColumn('contractor_fetch_reference_id');
        });

        Schema::table('contact_details', function (Blueprint $table) {
            $table->dropColumn('contractor_fetch_reference_id');
        });
    }
};
