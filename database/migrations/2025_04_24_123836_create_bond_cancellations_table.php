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
        Schema::create('bond_cancellations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('proposal_id')->nullable();
            $table->string('bond_number')->nullable();
            $table->unsignedBigInteger('contractor_id')->nullable();
            $table->unsignedBigInteger('beneficiary_id')->nullable();
            $table->unsignedBigInteger('project_details_id')->nullable();
            $table->unsignedBigInteger('tender_id')->nullable();
            $table->unsignedBigInteger('bond_type_id')->nullable();
            $table->date('bond_start_date')->nullable();
            $table->date('bond_end_date')->nullable();
            $table->enum('bond_conditionality', ['Conditional', 'Unconditional'])->nullable();
            $table->unsignedDecimal('premium_amount', 18, 0)->nullable();
            $table->date('cancellation_date')->nullable();
            $table->enum('bond_cancellation_type', ['pre_project', 'mid_project', 'any_other_type'])->nullable();
            $table->text('pre_project_remarks')->nullable();
            $table->text('mid_project_remarks')->nullable();
            $table->text('any_other_type_remarks')->nullable();
            $table->text('remarks')->nullable();
            $table->enum('is_refund', ['Yes', 'No'])->nullable();
            $table->text('refund_remarks')->nullable();
            $table->enum('is_original_bond_received', ['Yes', 'No'])->nullable();
            $table->enum('is_confirming_foreclosure', ['Yes', 'No'])->nullable();
            $table->enum('is_any_other_proof', ['Yes', 'No'])->nullable();
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
        Schema::dropIfExists('bond_cancellations');
    }
};
