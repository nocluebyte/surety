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
            $table->unsignedBigInteger('intermediary_detail_id')->nullable()->after('broker_mandate');
            $table->string('intermediary_detail_type')->nullable()->after('intermediary_detail_id');
            $table->string('intermediary_detail_name')->nullable()->after('intermediary_detail_type');
            $table->string('intermediary_detail_mobile')->nullable()->after('intermediary_detail_name');
            $table->text('intermediary_detail_address')->nullable()->after('intermediary_detail_mobile');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bond_policies_issue_checklist', function (Blueprint $table) {
            $table->dropColumn([
                'intermediary_detail_id',
                'intermediary_detail_type',
                'intermediary_detail_name',
                'intermediary_detail_mobile',
                'intermediary_detail_address'
            ]);
        });
    }
};
