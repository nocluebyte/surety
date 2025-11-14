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
        Schema::table('tender_evaluations', function (Blueprint $table) {
            $table->integer('cases_id')->nullable()->after('proposal_id');
        });
        Schema::table('tender_evaluation_locations', function (Blueprint $table) {
            $table->integer('cases_id')->nullable()->after('proposal_id');
        });
        Schema::table('tender_evaluation_product_alloweds', function (Blueprint $table) {
            $table->integer('cases_id')->nullable()->after('proposal_id');
        });
        Schema::table('tender_evaluation_work_types', function (Blueprint $table) {
            $table->integer('cases_id')->nullable()->after('proposal_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tender_evaluations', function (Blueprint $table) {
            $table->dropColumn('cases_id');
        });
        Schema::table('tender_evaluation_locations', function (Blueprint $table) {
            $table->dropColumn('cases_id');
        });
        Schema::table('tender_evaluation_product_alloweds', function (Blueprint $table) {
            $table->dropColumn('cases_id');
        });
        Schema::table('tender_evaluation_work_types', function (Blueprint $table) {
            $table->dropColumn('cases_id');
        });
    }
};
