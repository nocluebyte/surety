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
        Schema::table('bid_bonds', function (Blueprint $table) {
            $table->tinyInteger('is_invocation_notification')->default(0)->after('is_checklist_approved');
        });
        Schema::table('performance_bonds', function (Blueprint $table) {
            $table->tinyInteger('is_invocation_notification')->default(0)->after('is_checklist_approved');
        });
        Schema::table('advance_payment_bonds', function (Blueprint $table) {
            $table->tinyInteger('is_invocation_notification')->default(0)->after('is_checklist_approved');
        });
        Schema::table('retention_bonds', function (Blueprint $table) {
            $table->tinyInteger('is_invocation_notification')->default(0)->after('is_checklist_approved');
        });
        Schema::table('maintenance_bonds', function (Blueprint $table) {
            $table->tinyInteger('is_invocation_notification')->default(0)->after('is_checklist_approved');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bid_bonds', function (Blueprint $table) {
            $table->dropColumn('is_invocation_notification');
        });
        Schema::table('performance_bonds', function (Blueprint $table) {
            $table->dropColumn('is_invocation_notification');
        });
        Schema::table('advance_payment_bonds', function (Blueprint $table) {
            $table->dropColumn('is_invocation_notification');
        });
        Schema::table('retention_bonds', function (Blueprint $table) {
            $table->dropColumn('is_invocation_notification');
        });
        Schema::table('maintenance_bonds', function (Blueprint $table) {
            $table->dropColumn('is_invocation_notification');
        });
    }
};
