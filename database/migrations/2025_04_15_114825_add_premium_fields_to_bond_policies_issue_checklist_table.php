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
            $table->integer('past_premium')->nullable()->after('premium_amount');
            $table->integer('net_premium')->nullable()->after('past_premium');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bond_policies_issue_checklist', function (Blueprint $table) {
            $table->dropColumn('past_premium');
            $table->dropColumn('net_premium');
        });
    }
};
