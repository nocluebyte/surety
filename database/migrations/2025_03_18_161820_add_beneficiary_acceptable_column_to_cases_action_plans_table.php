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
            $table->enum('beneficiary_acceptable',['Yes','No'])->default('No')->after('adverse_notification_remark');
            $table->longText('beneficiary_acceptable_remark')->nullable()->after('beneficiary_acceptable');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cases_action_plans', function (Blueprint $table) {
            $table->dropColumn('beneficiary_acceptable');
            $table->dropColumn('beneficiary_acceptable_remark');
        });
    }
};
