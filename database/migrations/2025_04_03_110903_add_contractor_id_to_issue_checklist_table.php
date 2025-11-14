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
        Schema::table('bond_policies_issue_checklist', function (Blueprint $table) {
            $table->unsignedBigInteger('contractor_id')->nullable()->after('version');
        });
        Schema::table('bond_policies_issue', function (Blueprint $table) {
            $table->unsignedBigInteger('contractor_id')->nullable()->after('version');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bond_policies_issue_checklist', function (Blueprint $table) {
            $table->dropColumn('contractor_id');
        });
        Schema::table('bond_policies_issue', function (Blueprint $table) {
            $table->dropColumn('contractor_id');
        });
    }
};
