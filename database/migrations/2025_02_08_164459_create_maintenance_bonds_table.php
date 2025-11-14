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
        Schema::create('maintenance_bonds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->nullable();
            $table->unsignedBigInteger('version')->nullable();
            $table->string('source')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('proposal_id')->nullable();
            $table->string('contract_type')->nullable();
            $table->unsignedBigInteger('tender_id')->nullable();
            $table->unsignedDecimal('bond_value', 18, 0)->nullable();
            $table->unsignedBigInteger('contractor_id')->nullable();
            $table->string('pan_no')->nullable();
            $table->string('bond_number')->nullable();
            $table->string('full_name')->nullable();
            $table->text('address')->nullable();
            $table->unsignedInteger('country_id')->nullable();
            $table->unsignedInteger('state_id')->nullable();
            $table->string('city')->nullable();
            $table->string('post_code')->nullable();
            $table->enum('joint_venture', ['Yes', 'No'])->default('Yes');
            $table->string('name')->nullable();
            $table->unsignedDecimal('shares', 18, 0)->nullable();
            $table->text('distribution')->nullable();
            $table->enum('beneficiary', ['Public', 'Private'])->default('Public');
            $table->unsignedDecimal('total_bond_value', 18, 0)->nullable();
            $table->unsignedBigInteger('reinsurance_grouping_id')->nullable();
            $table->enum('want_to_review', ['Yes', 'No'])->default('Yes');
            $table->unsignedBigInteger('cases_id')->nullable();
            $table->unsignedBigInteger('cases_underwriter_id')->nullable();
            $table->string('underlying')->nullable();
            $table->string('type')->nullable();
            $table->string('location')->nullable();
            $table->text('main_obligation')->nullable();
            $table->unsignedDecimal('contract_price', 18, 0)->nullable();
            $table->string('contract_period')->nullable();
            $table->text('relevant_conditions')->nullable();
            $table->text('underlying_risk')->nullable();
            $table->unsignedBigInteger('financing_sources_id')->nullable();
            $table->string('bond_issued')->nullable();
            $table->date('bond_start_date')->nullable();
            $table->date('bond_end_date')->nullable();
            $table->string('triggers_of_bonds')->nullable();
            $table->unsignedDecimal('bond_amount', 18, 0)->nullable();
            $table->string('bond_period')->nullable();
            $table->text('bond_period_description')->nullable();
            $table->string('bond_required')->nullable();
            $table->text('bond_wording')->nullable();
            $table->text('bond_collateral')->nullable();
            $table->string('assessment_of_risk')->nullable();
            $table->text('assessment_overview')->nullable();
            $table->text('assessment_resources')->nullable();
            $table->text('assessment_annual_reports')->nullable();
            $table->text('assessment_ratings')->nullable();
            $table->text('further_relevant_information')->nullable();
            $table->text('bank_guarantees_details')->nullable();
            $table->unsignedTinyInteger('is_amendment')->default(0);
            $table->unsignedTinyInteger('is_nbi')->default(0);
            $table->unsignedTinyInteger('is_checklist_approved')->default(0);
            $table->string('status')->nullable();
            $table->unsignedBigInteger('parent_maintenance_bond_id')->nullable();

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
        Schema::dropIfExists('maintenance_bonds');
    }
};
