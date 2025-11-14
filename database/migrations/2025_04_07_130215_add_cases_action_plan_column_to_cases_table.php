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
        Schema::table('cases', function (Blueprint $table) {
            $table->string('cases_action_amendment_type')->nullable()->after('decision_draft_taken_date');
            $table->longText('cases_action_reason_for_submission')->nullable()->after('cases_action_amendment_type');
            $table->enum('cases_action_adverse_notification',['Yes','No'])->default('No')->nullable()->after('cases_action_reason_for_submission');
            $table->longText('cases_action_adverse_notification_remark')->nullable()->after('cases_action_adverse_notification');
            $table->enum('cases_action_beneficiary_acceptable',['Yes','No'])->default('No')->nullable()->after('cases_action_adverse_notification_remark');
            $table->longText('cases_action_beneficiary_acceptable_remark')->nullable()->after('cases_action_beneficiary_acceptable');
            $table->enum('cases_action_bond_invocation',['Yes','No'])
            ->nullable()->after('cases_action_beneficiary_acceptable_remark');
            $table->longText('cases_action_bond_invocation_remark')->nullable()->after('cases_action_bond_invocation');
            $table->enum('cases_action_blacklisted_contractor',['Yes','No'])
            ->nullable()->after('cases_action_bond_invocation_remark');
            $table->longText('cases_action_blacklisted_contractor_remark')->nullable()->after('cases_action_blacklisted_contractor');
            $table->string('cases_action_audited')->nullable()->after('cases_action_beneficiary_acceptable_remark');
            $table->string('cases_action_consolidated')->nullable()->after('cases_action_audited');
            $table->unsignedBigInteger('cases_action_currency_id')->nullable()->after('cases_action_consolidated');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cases', function (Blueprint $table) {
            $table->dropColumn([
                'cases_action_amendment_type',
                'cases_action_reason_for_submission',
                'cases_action_adverse_notification',
                'cases_action_adverse_notification_remark',
                'cases_action_beneficiary_acceptable',
                'cases_action_beneficiary_acceptable_remark',
                'cases_action_audited',
                'cases_action_consolidated',
                'cases_action_currency_id'
            ]);
        });
    }
};
