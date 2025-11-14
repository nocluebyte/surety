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
        Schema::table('performance_bonds', function (Blueprint $table) {
            $table->enum('want_to_review', ['Yes', 'No'])->default('No')->after('pep_details');
            $table->integer('cases_id')->nullable()->after('want_to_review');
            $table->integer('cases_underwriter_id')->nullable()->after('cases_id');
        });
        Schema::table('bid_bonds', function (Blueprint $table) {
            $table->enum('want_to_review', ['Yes', 'No'])->default('No')->after('reinsurance_grouping_id');
            $table->integer('cases_id')->nullable()->after('want_to_review');
            $table->integer('cases_underwriter_id')->nullable()->after('cases_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('performance_bonds', function (Blueprint $table) {
            $table->dropColumn('want_to_review');
            $table->dropColumn('cases_id');
            $table->dropColumn('cases_underwriter_id');
        });
        Schema::table('bid_bonds', function (Blueprint $table) {
            $table->dropColumn('want_to_review');
            $table->dropColumn('cases_id');
            $table->dropColumn('cases_underwriter_id');
        });
    }
};
