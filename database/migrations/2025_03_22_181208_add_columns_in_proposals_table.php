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
            $table->string('registration_no')->nullable()->after('date_of_incorporation');
            $table->string('contractor_company_name')->nullable()->after('registration_no');
            $table->string('contractor_website')->nullable()->after('contractor_company_name');
            $table->unsignedBigInteger('contractor_country_id')->nullable()->after('contractor_website');
            $table->unsignedBigInteger('contractor_state_id')->nullable()->after('contractor_country_id');
            $table->string('contractor_city')->nullable()->after('contractor_state_id');
            $table->string('contractor_pincode')->nullable()->after('contractor_city');
            $table->string('contractor_gst_no')->nullable()->after('contractor_pincode');
            $table->string('contractor_pan_no')->nullable()->after('contractor_gst_no');
            $table->string('contractor_email')->nullable()->after('contractor_pan_no');
            $table->string('contractor_mobile')->nullable()->after('contractor_email');
            $table->unsignedBigInteger('principle_type_id')->nullable()->after('contractor_mobile');
            $table->enum('are_you_blacklisted', ['Yes', 'No'])->nullable()->after('principle_type_id');
            $table->unsignedBigInteger('tender_details_id')->nullable()->after('are_you_blacklisted');
            $table->string('tender_header')->nullable()->after('tender_id');
            $table->unsignedDecimal('contract_value', 18, 0)->nullable()->after('tender_header');
            $table->unsignedBigInteger('period_of_contract')->nullable()->after('contract_value');
            $table->string('location')->after('period_of_contract');
            $table->unsignedBigInteger('project_type')->nullable()->after('location');
            $table->unsignedDecimal('tender_bond_value', 18, 0)->nullable()->after('project_type');
            $table->unsignedBigInteger('bond_type_id')->nullable()->after('tender_bond_value');
            $table->date('rfp_date')->nullable()->after('bond_type_id');
            $table->string('type_of_contracting')->nullable()->after('rfp_date');
            $table->text('tender_description')->nullable()->after('type_of_contracting');
            $table->text('project_description')->nullable()->after('tender_description');
            $table->unsignedBigInteger('project_details')->nullable()->after('project_description');
            $table->unsignedBigInteger('pd_beneficiary')->nullable()->after('project_details');
            $table->string('pd_project_name')->nullable()->after('pd_beneficiary');
            $table->text('pd_project_description')->nullable()->after('pd_project_name');
            $table->unsignedDecimal('pd_project_value', 18, 0)->nullable()->after('pd_project_description');
            $table->unsignedBigInteger('pd_type_of_project')->nullable()->after('pd_project_value');
            $table->date('pd_project_start_date')->nullable()->after('pd_type_of_project');
            $table->date('pd_project_end_date')->nullable()->after('pd_project_start_date');
            $table->unsignedBigInteger('pd_period_of_project')->nullable()->after('pd_project_end_date');

            $table->string('beneficiary_registration_no')->nullable()->after('pd_period_of_project');
            $table->string('beneficiary_company_name')->nullable()->after('beneficiary_registration_no');
            $table->string('beneficiary_email')->nullable()->after('beneficiary_company_name');
            $table->string('beneficiary_phone_no')->nullable()->after('beneficiary_email');
            $table->string('beneficiary_website')->nullable()->after('beneficiary_phone_no');
            $table->string('beneficiary_city')->nullable()->after('beneficiary_website');
            $table->unsignedBigInteger('beneficiary_pincode')->nullable()->after('beneficiary_city');
            $table->string('beneficiary_gst_no')->nullable()->after('beneficiary_pincode');
            $table->string('beneficiary_pan_no')->nullable()->after('beneficiary_gst_no');
            $table->unsignedBigInteger('establishment_type_id')->nullable()->after('beneficiary_pan_no');
            $table->unsignedBigInteger('ministry_type_id')->nullable()->after('establishment_type_id');
            $table->text('beneficiary_bond_wording')->nullable()->after('ministry_type_id');

            $table->unsignedBigInteger('bond_type')->nullable()->after('bond_value');
            $table->unsignedDecimal('project_value', 18, 0)->nullable()->after('bond_type');
            $table->string('bond_triggers')->nullable()->after('project_value');
            $table->text('main_obligation')->nullable()->after('bond_triggers');
            $table->text('bond_period_description')->nullable()->after('main_obligation');
            $table->string('bond_required')->nullable()->after('bond_period_description');
            $table->text('bond_wording')->nullable()->after('bond_required');
            $table->text('bond_collateral')->nullable()->after('bond_wording');
            $table->text('distribution')->nullable()->after('bond_collateral');

            $table->unsignedBigInteger('agency_id')->nullable()->after('distribution');
            $table->unsignedBigInteger('agency_rating_id')->nullable()->after('agency_id');
            $table->text('rating_remarks')->nullable()->after('agency_rating_id');

            $table->dropColumn('bond_issued_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proposals', function (Blueprint $table) {
            $table->date('bond_issued_date')->nullable();

            $table->dropColumn([
                'registration_no',
                'contractor_company_name',
                'contractor_website',
                'contractor_country_id',
                'contractor_state_id',
                'contractor_city',
                'contractor_pincode',
                'contractor_gst_no',
                'contractor_pan_no',
                'contractor_email',
                'contractor_mobile',
                'principle_type_id',
                'are_you_blacklisted',
                'tender_details_id',
                'tender_header',
                'contract_value',
                'period_of_contract',
                'location',
                'project_type',
                'tender_bond_value',
                'bond_type_id',
                'rfp_date',
                'type_of_contracting',
                'tender_description',
                'project_description',
                'project_details',
                'pd_beneficiary',
                'pd_project_name',
                'pd_project_description',
                'pd_project_value',
                'pd_type_of_project',
                'pd_project_start_date',
                'pd_project_end_date',
                'pd_period_of_project',
                'beneficiary_registration_no',
                'beneficiary_company_name',
                'beneficiary_email',
                'beneficiary_phone_no',
                'beneficiary_website',
                'beneficiary_city',
                'beneficiary_pincode',
                'beneficiary_gst_no',
                'beneficiary_pan_no',
                'establishment_type_id',
                'ministry_type_id',
                'beneficiary_bond_wording',
                'bond_type',
                'project_value',
                'bond_triggers',
                'main_obligation',
                'bond_period_description',
                'bond_required',
                'bond_wording',
                'bond_collateral',
                'distribution',
                'agency_id',
                'agency_rating_id',
                'rating_remarks',
            ]);
        });
    }
};
