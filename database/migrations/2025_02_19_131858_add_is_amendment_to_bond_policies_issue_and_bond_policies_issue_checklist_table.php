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
        Schema::table('bond_policies_issue', function (Blueprint $table) {
            $table->tinyInteger('is_amendment')->default(0)->after('status');
        });

        Schema::table('bond_policies_issue_checklist', function (Blueprint $table) {
            $table->tinyInteger('is_amendment')->default(0)->after('bank_address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bond_policies_issue', function (Blueprint $table) {
            $table->dropColumn('is_amendment');
        });

        Schema::table('bond_policies_issue_checklist', function (Blueprint $table) {
            $table->dropColumn('is_amendment');
        });
    }
};
