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
        Schema::table('proposals', function (Blueprint $table) {
            $table->tinyInteger('is_amendment')->default(0)->after('status');
        });

        Schema::table('proposal_contractors', function (Blueprint $table) {
            $table->tinyInteger('is_amendment')->default(0)->after('remaining_cap');
        });

        Schema::table('trade_sector_items', function (Blueprint $table) {
            $table->tinyInteger('is_amendment')->default(0)->after('is_main');
        });

        Schema::table('contractor_items', function (Blueprint $table) {
            $table->tinyInteger('is_amendment')->default(0)->after('share_holding');
        });

        Schema::table('contact_details', function (Blueprint $table) {
            $table->tinyInteger('is_amendment')->default(0)->after('phone_no');
        });

        Schema::table('proposal_beneficiary_trade_sectors', function (Blueprint $table) {
            $table->tinyInteger('is_amendment')->default(0)->after('is_main');
        });

        Schema::table('banking_limits', function (Blueprint $table) {
            $table->tinyInteger('is_amendment')->default(0)->after('other_banking_details');
        });

        Schema::table('order_book_and_future_projects', function (Blueprint $table) {
            $table->tinyInteger('is_amendment')->default(0)->after('current_status');
        });

        Schema::table('project_track_records', function (Blueprint $table) {
            $table->tinyInteger('is_amendment')->default(0)->after('bg_amount');
        });

        Schema::table('management_profiles', function (Blueprint $table) {
            $table->tinyInteger('is_amendment')->default(0)->after('experience');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proposals', function (Blueprint $table) {
            $table->dropColumn('is_amendment');
        });

        Schema::table('proposal_contractors', function (Blueprint $table) {
            $table->dropColumn('is_amendment');
        });

        Schema::table('trade_sector_items', function (Blueprint $table) {
            $table->dropColumn('is_amendment');
        });

        Schema::table('contractor_items', function (Blueprint $table) {
            $table->dropColumn('is_amendment');
        });

        Schema::table('contact_details', function (Blueprint $table) {
            $table->dropColumn('is_amendment');
        });

        Schema::table('proposal_beneficiary_trade_sectors', function (Blueprint $table) {
            $table->dropColumn('is_amendment');
        });

        Schema::table('banking_limits', function (Blueprint $table) {
            $table->dropColumn('is_amendment');
        });

        Schema::table('order_book_and_future_projects', function (Blueprint $table) {
            $table->dropColumn('is_amendment');
        });

        Schema::table('project_track_records', function (Blueprint $table) {
            $table->dropColumn('is_amendment');
        });

        Schema::table('management_profiles', function (Blueprint $table) {
            $table->dropColumn('is_amendment');
        });
    }
};
