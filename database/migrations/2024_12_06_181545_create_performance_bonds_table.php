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
        Schema::create('performance_bonds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->nullable();
            $table->integer('contractor_id')->default(0);
            $table->string('pan_no')->nullable();
            $table->string('contact_person_name')->nullable();
            $table->integer('contact_person_designation')->default(0);
            $table->string('contact_person_email')->nullable();
            $table->string('contact_person_phone_no')->nullable();
            $table->string('contact_person_ckyc_no')->nullable();
            $table->text('register_address')->nullable();
            $table->string('parent_group')->nullable();
            $table->date('date_of_incorporation')->nullable();
            $table->string('authorized_capital')->nullable();
            $table->integer('type_of_entity')->default(0);
            $table->text('business_activity')->nullable();
            $table->enum('is_accreditation', ['Yes', 'No'])->default('Yes');
            $table->string('issuer_name')->nullable();
            $table->date('accreditation_date')->nullable();
            $table->enum('is_agency_rating', ['Yes', 'No'])->default('Yes');
            $table->string('agency_rating')->nullable();
            $table->date('agency_rating_date')->nullable();
            $table->string('chairman_name')->nullable();
            $table->integer('chairman_designation')->default(0);
            $table->text('chairman_address')->nullable();
            $table->decimal('shares', 18, 0)->default(0);
            $table->decimal('networth', 18, 0)->default(0);
            $table->enum('if_proposer_pep', ['Yes', 'No'])->default('Yes');
            $table->text('pep_details')->nullable();
            $table->integer('beneficiary_id')->default(0);
            $table->enum('beneficiary_type', ['Public', 'Private'])->default('Public');
            $table->text('beneficiary_address')->nullable();
            $table->decimal('contract_value_of_project', 18, 0)->default(0);
            $table->integer('period_of_contract')->default(0);
            $table->integer('tender_id')->default(0);
            $table->date('rfp_date')->nullable();
            $table->text('project_description')->nullable();
            $table->string('type_of_contracting')->nullable();
            $table->integer('type_of_bond')->default(0);
            $table->text('bond_conditionality')->nullable();
            $table->decimal('bond_value', 18, 0)->default(0);
            $table->date('bond_start_date')->nullable();
            $table->date('bond_end_date')->nullable();
            $table->integer('bond_period')->default(0);
            $table->string('bond_collateral')->nullable();
            $table->string('claim_reporting_period')->nullable();
            $table->enum('rfp_of_project', ['Yes', 'No'])->default('Yes');
            $table->text('funding_arrangement')->nullable();
            $table->text('cashflow_projection')->nullable();
            $table->text('trigger_of_bond')->nullable();
            $table->text('bid_requirement')->nullable();
            $table->text('bank_status_report')->nullable();
            $table->text('relevant_conditions')->nullable();
            $table->text('additional_underlying_risk')->nullable();
            $table->text('guarantees_details')->nullable();
            $table->enum('audited_financials_public_domain', ['Yes', 'No'])->default('Yes');
            $table->text('audited_financials_details')->nullable();
            $table->enum('latest_presentation_domain', ['Yes', 'No'])->default('Yes');
            $table->text('latest_presentation_details')->nullable();
            $table->enum('rating_rationale_domain', ['Yes', 'No'])->default('Yes');
            $table->text('rating_rationale_details')->nullable();
            $table->text('last_5_years_completed_projects')->nullable();
            $table->text('ongoing_projects_details')->nullable();
            $table->text('contract_details')->nullable();
            $table->text('updated_blacklisting_details')->nullable();
            $table->text('total_bgs_provided')->nullable();
            $table->date('total_bgs_provided_date')->nullable();
            $table->decimal('amount_of_margin', 18, 0)->default(0);
            $table->text('circumstances_surety_bond')->nullable();
            $table->text('bank_guarantees_details')->nullable();
            $table->enum('is_action_against_proposer', ['Yes', 'No'])->default('Yes');
            $table->text('action_details')->nullable();
            $table->text('contractor_failed_project_details')->nullable();
            $table->text('completed_rectification_details')->nullable();
            $table->text('performance_security_details')->nullable();
            $table->text('relevant_other_information')->nullable();

            $table->enum('is_active', ['Yes', 'No'])->default('Yes');
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
            $table->string('ip')->nullable();
            $table->string('update_from_ip')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('performance_bonds');
    }
};
