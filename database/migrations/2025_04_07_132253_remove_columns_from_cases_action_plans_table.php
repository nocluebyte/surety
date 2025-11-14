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
        Schema::table('cases_action_plans', function (Blueprint $table) {
            $table->dropColumn([
                'reason_for_submission',
                'adverse_notification',
                'adverse_notification_remark',
                'beneficiary_acceptable',
                'beneficiary_acceptable_remark',
                'audited',
                'consolidated',
                'currency_id'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cases_action_plans', function (Blueprint $table) {
            $table->longText('reason_for_submission')->nullable()->after('contractor_id');
            $table->enum('adverse_notification',['Yes','No'])->default('No')->nullable()->after('reason_for_submission');
            $table->longText('adverse_notification_remark')->nullable()->after('adverse_notification');
            $table->enum('beneficiary_acceptable',['Yes','No'])->default('No')->nullable()->after('adverse_notification_remark');
            $table->longText('beneficiary_acceptable_remark')->nullable()->after('beneficiary_acceptable');
            $table->string('audited')->nullable()->after('beneficiary_acceptable_remark');
            $table->string('consolidated')->nullable()->after('audited');
            $table->unsignedBigInteger('currency_id')->nullable()->after('consolidated');
        });
    }
};
