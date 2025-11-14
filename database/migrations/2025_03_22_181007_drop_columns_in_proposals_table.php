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
            $table->dropColumn([
                'source', 'user_id', 'first_name', 'middle_name', 'last_name', 'full_name', 'is_accreditation', 'issuer_name', 'accreditation_date', 'is_agency_rating', 'agency_rating', 'agency_rating_date', 'chairman_name', 'chairman_address', 'chairman_designation', 'shares', 'networth', 'is_manual_entry', 'contract_value_of_project', 'period_tenor_of_contract', 'project_brief', 'type_of_bond', 'is_project_agreement', 'project_attachment', 'rfp_of_project', 'rfp_attachment', 'relevant_approvals', 'funding_arrangement_details', 'cashflow_projection', 'project_payment', 'trigger_of_bond', 'feasibility_report', 'is_feasibility_attachment', 'feasibility_attachment', 'bank_status_report', 'additional_underlying_risk', 'guarantees_details', 'latest_sanction_attachment', 'audited_financials_public_domain', 'audited_financials_attachment', 'audited_financials_details', 'last_3_years_itr', 'analysis_of_partner', 'latest_presentation_domain', 'latest_presentation_attachment', 'latest_presentation_details', 'group_structure_diagram', 'rating_rationale_domain', 'rating_rationale_attachment', 'rating_rationale_details', 'last_5_years_completed_projects', 'last_5_years_completed_projects_file', 'ongoing_projects_details', 'updated_blacklisting_details', 'total_bgs_provided', 'total_bgs_provided_date', 'amount_of_margin', 'circumstances_surety_bond', 'bank_guarantees_details']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proposals', function (Blueprint $table) {
            $table->string('source')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('full_name')->nullable();
            $table->enum('is_accreditation', ['Yes', 'No'])->default('Yes');
            $table->string('issuer_name')->nullable();
            $table->date('accreditation_date')->nullable();
            $table->enum('is_agency_rating', ['Yes', 'No'])->default('Yes');
            $table->string('agency_rating')->nullable();
            $table->date('agency_rating_date')->nullable();
            $table->string('chairman_name')->nullable();
            $table->text('chairman_address')->nullable();
            $table->integer('chairman_designation')->nullable();
            $table->decimal('shares', 18, 0)->nullable();
            $table->decimal('networth', 18, 0)->nullable();
            $table->enum('is_manual_entry', ['Yes', 'No'])->default('Yes');
            $table->decimal('contract_value_of_project', 18, 0)->nullable();
            $table->integer('period_tenor_of_contract')->nullable();
            $table->text('project_brief')->nullable();
            $table->integer('type_of_bond')->nullable();
            $table->enum('is_project_agreement', ['Yes', 'No'])->default('Yes');
            $table->enum('rfp_of_project', ['Yes', 'No'])->default('Yes');
            $table->string('project_attachment')->nullable();
            $table->string('rfp_attachment')->nullable();
            $table->text('relevant_approvals')->nullable();
            $table->text('funding_arrangement_details')->nullable();
            $table->text('cashflow_projection')->nullable();
            $table->text('project_payment')->nullable();
            $table->text('trigger_of_bond')->nullable();
            $table->text('feasibility_report')->nullable();
            $table->enum('is_feasibility_attachment', ['Yes', 'No'])->default('Yes');
            $table->string('feasibility_attachment')->nullable();
            $table->text('bank_status_report')->nullable();
            $table->text('additional_underlying_risk')->nullable();
            $table->text('guarantees_details')->nullable();
            $table->enum('audited_financials_public_domain', ['Yes', 'No'])->default('Yes');
            $table->string('latest_sanction_attachment')->nullable();
            $table->string('audited_financials_attachment')->nullable();
            $table->string('audited_financials_details')->nullable();
            $table->string('last_3_years_itr')->nullable();
            $table->string('analysis_of_partner')->nullable();
            $table->enum('latest_presentation_domain', ['Yes', 'No'])->default('Yes');
            $table->string('latest_presentation_attachment')->nullable();
            $table->string('latest_presentation_details')->nullable();
            $table->string('group_structure_diagram')->nullable();
            $table->enum('rating_rationale_domain', ['Yes', 'No'])->default('Yes');
            $table->string('rating_rationale_attachment')->nullable();
            $table->string('rating_rationale_details')->nullable();
            $table->text('last_5_years_completed_projects')->nullable();
            $table->string('last_5_years_completed_projects_file')->nullable();
            $table->text('ongoing_projects_details')->nullable();
            $table->text('updated_blacklisting_details')->nullable();
            $table->text('total_bgs_provided')->nullable();
            $table->date('total_bgs_provided_date')->nullable();
            $table->unsignedDecimal('amount_of_margin', 18, 0)->nullable();
            $table->text('circumstances_surety_bond')->nullable();
            $table->text('bank_guarantees_details')->nullable();
        });
    }
};
