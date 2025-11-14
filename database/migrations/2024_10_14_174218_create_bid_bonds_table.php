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
        Schema::create('bid_bonds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('full_name')->nullable();
            $table->text('address')->nullable();
            $table->integer('country_id')->default(0);
            $table->integer('state_id')->default(0);
            $table->string('city')->nullable();
            $table->string('post_code')->nullable();
            $table->string('certificate_of_incorporation')->nullable();
            $table->string('memorandum_and_articles')->nullable();
            $table->string('company_pan_no')->nullable();
            $table->string('gst_certificate')->nullable();
            $table->enum('joint_venture', ['Yes', 'No'])->default('Yes');
            $table->string('name')->nullable();
            $table->decimal('shares', 18, 0)->default(0);
            $table->text('distribution')->nullable();
            $table->enum('beneficiary', ['Public', 'Private'])->nullable();
            $table->decimal('total_bond_value', 18, 0)->default(0);
            $table->string('underlying')->nullable();
            $table->string('type')->nullable();
            $table->string('location')->nullable();
            $table->text('main_obligation')->nullable();
            $table->decimal('contract_price', 18, 0)->default(0);
            $table->string('contract_period')->nullable();
            $table->text('relevant_conditions')->nullable();
            $table->text('underlying_risk')->nullable();
            $table->integer('financing_sources_id')->default(0);
            $table->string('bond_issued')->nullable();
            $table->string('triggers_of_bonds')->nullable();
            $table->decimal('bond_amount', 18, 0)->default(0);
            $table->string('bond_period')->nullable();
            $table->text('bond_period_description')->nullable();
            $table->string('bond_required')->nullable();
            $table->text('bond_wording')->nullable();
            $table->string('bond_wording_file')->nullable();
            $table->text('bond_collateral')->nullable();
            $table->string('assessment_of_risk')->nullable();
            $table->text('assessment_overview')->nullable();
            $table->text('assessment_resources')->nullable();
            $table->text('assessment_annual_reports')->nullable();
            $table->text('assessment_ratings')->nullable();
            $table->text('further_relevant_information')->nullable();
            $table->text('bank_guarantees_details')->nullable();
            $table->enum('is_active', ['Yes', 'No'])->default('Yes');
            $table->string('ip')->nullable();
            $table->string('update_from_ip')->nullable();
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bid_bonds');
    }
};
