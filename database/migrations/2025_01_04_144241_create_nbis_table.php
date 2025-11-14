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
        Schema::create('nbis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('proposal_id')->nullable();
            $table->unsignedBigInteger('contractor_id')->nullable();
            $table->longText('insured_address')->nullable();
            $table->longText('project_details')->nullable();
            $table->unsignedBigInteger('beneficiary_id')->nullable();
            $table->longText('beneficiary_address')->nullable();
            $table->longText('beneficiary_contact_person_name')->nullable();
            $table->string('beneficiary_contact_person_phone_no')->nullable();
            $table->unsignedBigInteger('bond_type')->nullable();
            $table->string('bond_conditionality')->nullable();
            $table->decimal('contract_value',18,2)->nullable();
            $table->unsignedBigInteger('contract_currency_id')->nullable();
            $table->decimal('bond_value',18,2)->nullable();
            $table->decimal('cash_margin_if_applicable',18,2)->nullable();
            $table->string('tender_id_loa_ref_no')->nullable();
            $table->date('bond_period_start_date')->nullable();
            $table->date('bond_period_end_date')->nullable();
            $table->decimal('bond_period_days',18,0)->nullable();
            $table->decimal('rate',18,2)->nullable();
            $table->decimal('net_premium',18,2)->nullable();
            $table->decimal('gst',18,2)->nullable();
            $table->decimal('gst_amount',18,2)->nullable();
            $table->decimal('gross_premium',18,2)->nullable();
            $table->decimal('stamp_duty_charges',18,2)->nullable();
            $table->decimal('total_premium_including_stamp_duty',18,2)->nullable();
            $table->longText('intermediary_name')->nullable();
            $table->longText('intermediary_code_and_contact_details')->nullable();
            $table->longText('bond_wording')->nullable();
            $table->integer('year_id')->nullable();
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
        Schema::dropIfExists('nbis');
    }
};
