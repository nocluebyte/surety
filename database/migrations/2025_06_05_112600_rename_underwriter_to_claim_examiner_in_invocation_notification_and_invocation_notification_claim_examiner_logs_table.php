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
        Schema::table('invocation_notification', function (Blueprint $table) {
            $table->renameColumn('underwriter_id', 'claim_examiner_id');
            $table->renameColumn('underwriter_assigned_date', 'claim_examiner_assigned_date');
            $table->string('claim_examiner_type')->nullable()->after('bond_type_id');
        });

        Schema::table('invocation_notification_claim_examiner_logs', function (Blueprint $table) {
            $table->renameColumn('underwriter_id', 'claim_examiner_id');
            $table->date('claim_examiner_assigned_date')->nullable()->after('invocation_notification_id');
            $table->string('claim_examiner_type')->nullable()->after('claim_examiner_assigned_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invocation_notification', function (Blueprint $table) {
            $table->renameColumn('claim_examiner_id', 'underwriter_id');
            $table->renameColumn('claim_examiner_assigned_date', 'underwriter_assigned_date');
            $table->dropColumn([
                'claim_examiner_type',
            ]);
        });

        Schema::table('invocation_notification_claim_examiner_logs', function (Blueprint $table) {
            $table->renameColumn('claim_examiner_id', 'underwriter_id');
            $table->dropColumn([
                'claim_examiner_assigned_date',
                'claim_examiner_type',
            ]);
        });
    }
};
