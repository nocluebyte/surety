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
            $table->string('bond_number')->nullable()->after('invocation_date');
            $table->unsignedBigInteger('bond_policies_issue_id')->nullable()->after('proposal_id');
            $table->unsignedBigInteger('contractor_id')->nullable()->after('bond_number');
            $table->unsignedBigInteger('beneficiary_id')->nullable()->after('contractor_id');
            $table->unsignedBigInteger('tender_id')->nullable()->after('beneficiary_id');
            $table->unsignedBigInteger('project_details_id')->nullable()->after('tender_id');
            $table->renameColumn('bond_type', 'bond_type_id');
            $table->date('bond_start_date')->nullable()->after('project_details_id');
            $table->date('bond_end_date')->nullable()->after('bond_start_date');
            $table->string('bond_conditionality')->nullable()->after('bond_end_date');
        });

        DB::statement("ALTER TABLE invocation_notification CHANGE `invocation_amount` `invocation_amount` DECIMAL(18, 0) UNSIGNED NULL DEFAULT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invocation_notification', function (Blueprint $table) {
            $table->renameColumn('bond_type_id', 'bond_type');

            $table->dropColumn([
                'bond_number',
                'bond_policies_issue_id',
                'contractor_id',
                'beneficiary_id',
                'tender_id',
                'project_details_id',
                'bond_start_date',
                'bond_end_date',
                'bond_conditionality',
            ]);
        });

        DB::statement("ALTER TABLE invocation_notification CHANGE `invocation_amount` `invocation_amount` INT NULL DEFAULT NULL");
    }
};
