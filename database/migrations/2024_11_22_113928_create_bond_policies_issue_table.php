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
        Schema::create('bond_policies_issue', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('bond_id')->default(0);
            $table->string('bond_type')->nullable();
            $table->string('insured_name')->nullable();
            $table->text('insured_address')->nullable();
            $table->text('project_details')->nullable();
            $table->integer('beneficiary_id')->default(0);
            $table->text('beneficiary_address')->nullable();
            $table->string('beneficiary_phone_no')->nullable();
            $table->string('bond_conditionality')->nullable();
            $table->integer('contract_value')->default(0);
            $table->string('contract_currency')->nullable();
            $table->integer('bond_value')->default(0);
            $table->string('cash_margin')->nullable();
            $table->string('tender_id')->nullable();
            $table->date('bond_period_start_date')->nullable();
            $table->date('bond_period_end_date')->nullable();
            $table->integer('bond_period')->default(0);
            $table->integer('rate')->default(0);
            $table->integer('net_premium')->default(0);
            $table->integer('gst')->default(0);
            $table->integer('gst_amount')->default(0);
            $table->integer('gross_premium')->default(0);
            $table->integer('stamp_duty_charges')->default(0);
            $table->integer('total_premium')->default(0);
            $table->string('intermediary_name')->nullable();
            $table->string('intermediary_code')->nullable();
            $table->string('phone_no')->nullable();
            $table->text('special_condition')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('bond_policies_issue');
    }
};
