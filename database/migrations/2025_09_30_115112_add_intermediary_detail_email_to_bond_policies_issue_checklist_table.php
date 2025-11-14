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
            $table->string('intermediary_detail_code')->nullable()->after('intermediary_detail_type');
            $table->string('intermediary_detail_email')->nullable()->after('intermediary_detail_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bond_policies_issue_checklist', function (Blueprint $table) {
            $table->dropColumn([
                'intermediary_detail_code',
                'intermediary_detail_email'
            ]);
        });
    }
};
