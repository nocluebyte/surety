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
        Schema::create('bond_policies_issue_checklist', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('bond_id')->default(0);
            $table->string('bond_type')->nullable();
            $table->integer('premium_amount')->default(0);
            $table->string('utr_neft_details')->nullable();
            $table->date('date_of_receipt')->nullable();
            $table->string('booking_office_detail')->nullable();
            $table->enum('executed_deed_indemnity', ['Yes', 'No'])->default('Yes')->nullable();
            $table->text('deed_remarks')->nullable();
            $table->enum('executed_board_resolution', ['Yes', 'No'])->default('Yes')->nullable();
            $table->text('board_remarks')->nullable();
            $table->enum('broker_mandate', ['Broker', 'Agent','Direct'])->default('Broker')->nullable();
            $table->enum('collateral_available', ['Yes', 'No'])->default('Yes')->nullable();
            $table->text('collateral_remarks')->nullable();
            $table->integer('fd_amount')->default(0);
            $table->string('fd_issuing_bank_name')->nullable();
            $table->string('fd_issuing_branch_name')->nullable();
            $table->string('fd_receipt_number')->nullable();
            $table->string('bank_address')->nullable();
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
        Schema::dropIfExists('bond_policies_issue_checklist');
    }
};
