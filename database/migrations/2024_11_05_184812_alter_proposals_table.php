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
        Schema::table('proposals', function (Blueprint $table) {
            $table->enum('is_accreditation', ['Yes', 'No'])->default('Yes')->after('date_of_incorporation');
            $table->string('issuer_name')->nullable()->after('is_accreditation');
            $table->date('accreditation_date')->nullable()->after('issuer_name');
            $table->enum('is_agency_rating', ['Yes', 'No'])->default('Yes')->after('accreditation_date');
            $table->string('agency_rating')->nullable()->after('is_agency_rating');
            $table->integer('chairman_designation')->default(0)->after('chairman_address');
            $table->text('chairman_address')->change();
            $table->decimal('shares', 18, 0)->default(0)->after('chairman_designation');
            $table->decimal('networth', 18, 0)->default(0)->after('shares');
            $table->string('beneficiary_name')->nullable()->after('networth');
            $table->text('beneficiary_address')->nullable()->after('beneficiary_name');
            $table->string('beneficiary_type')->nullable()->after('beneficiary_address');
            $table->decimal('contract_value_of_project', 18, 0)->default(0)->after('beneficiary_type');
            $table->integer('period_tenor_of_contract')->default(0)->after('contract_value_of_project');
            $table->string('tender_id')->nullable()->after('period_tenor_of_contract');
            $table->text('project_brief')->nullable()->after('tender_id');
            $table->integer('type_of_bond')->default(0)->after('project_brief');
            $table->decimal('bond_value', 18, 0)->default(0)->after('type_of_bond');
            $table->integer('bond_period')->default(0)->after('bond_value');
            $table->date('bond_issued_date')->nullable()->after('bond_period');
            $table->enum('is_project_agreement', ['Yes', 'No'])->default('Yes')->after('bond_issued_date');
            $table->string('project_attachment')->nullable()->after('is_project_agreement');
            $table->enum('rfp_of_project', ['Yes', 'No'])->default('Yes')->after('project_attachment');
            $table->string('rfp_attachment')->nullable()->after('rfp_of_project');
            $table->text('relevant_approvals')->nullable()->after('rfp_attachment');
            $table->text('funding_arrangement_details')->nullable()->after('relevant_approvals');
            $table->text('cashflow_projection')->nullable()->after('funding_arrangement_details');
            $table->text('project_payment')->nullable()->after('cashflow_projection');
            $table->text('trigger_of_bond')->nullable()->after('project_payment');
            $table->text('feasibility_report')->nullable()->after('trigger_of_bond');
            $table->enum('is_feasibility_attachment', ['Yes', 'No'])->default('Yes')->after('feasibility_report');
            $table->string('feasibility_attachment')->nullable()->after('is_feasibility_attachment');
            $table->text('bid_requirement')->nullable()->after('feasibility_attachment');
            $table->text('bank_status_report')->nullable()->after('bid_requirement');
            $table->text('relevant_conditions')->nullable()->after('bank_status_report');
            $table->text('additional_underlying_risk')->nullable()->after('relevant_conditions');
            $table->text('guarantees_details')->nullable()->after('additional_underlying_risk');
            $table->string('latest_sanction_attachment')->nullable()->after('guarantees_details');
            $table->enum('audited_financials_public_domain', ['Yes', 'No'])->default('Yes')->after('latest_sanction_attachment');
            $table->string('audited_financials_attachment')->nullable()->after('audited_financials_public_domain');
            $table->string('audited_financials_details')->nullable()->after('audited_financials_attachment');
            $table->string('last_3_years_itr')->nullable()->after('audited_financials_details');
            $table->string('analysis_of_partner')->nullable()->after('last_3_years_itr');
            $table->enum('latest_presentation_domain', ['Yes', 'No'])->default('Yes')->after('analysis_of_partner');
            $table->string('latest_presentation_attachment')->nullable()->after('latest_presentation_domain');
            $table->string('latest_presentation_details')->nullable()->after('latest_presentation_attachment');
            $table->string('group_structure_diagram')->nullable()->after('latest_presentation_details');
            $table->enum('rating_rationale_domain', ['Yes', 'No'])->default('Yes')->after('group_structure_diagram');
            $table->string('rating_rationale_attachment')->nullable()->after('rating_rationale_domain');
            $table->string('rating_rationale_details')->nullable()->after('rating_rationale_attachment');
            $table->text('last_5_years_completed_projects')->nullable()->after('rating_rationale_details');
            $table->string('last_5_years_completed_projects_file')->nullable()->after('last_5_years_completed_projects');
            $table->text('ongoing_projects_details')->nullable()->after('last_5_years_completed_projects_file');
            $table->text('updated_blacklisting_details')->nullable()->after('ongoing_projects_details');
            $table->text('total_bgs_provided')->nullable()->after('updated_blacklisting_details');
            $table->date('total_bgs_provided_date')->nullable()->after('total_bgs_provided');
            $table->decimal('amount_of_margin', 18, 0)->default(0)->after('total_bgs_provided_date');
            $table->text('circumstances_surety_bond')->nullable()->after('amount_of_margin');
            $table->text('bank_guarantees_details')->nullable()->after('circumstances_surety_bond');
            $table->enum('is_bank_guarantee_provided', ['Yes', 'No'])->default('Yes')->after('bank_guarantees_details');
            $table->text('circumstance_short_notes')->nullable()->after('is_bank_guarantee_provided');
            $table->enum('is_action_against_proposer', ['Yes', 'No'])->default('Yes')->after('circumstance_short_notes');
            $table->text('action_details')->nullable()->after('is_action_against_proposer');
            $table->text('contractor_failed_project_details')->nullable()->after('action_details');
            $table->text('completed_rectification_details')->nullable()->after('contractor_failed_project_details');
            $table->text('performance_security_details')->nullable()->after('completed_rectification_details');
            $table->text('relevant_other_information')->nullable()->after('performance_security_details');
            $table->string('code')->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
