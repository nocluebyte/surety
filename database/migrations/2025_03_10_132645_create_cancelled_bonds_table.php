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
        Schema::create('cancelled_bonds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('bond_id')->nullable();
            $table->string('bond_type')->nullable();
            $table->enum('reason', ['project_cancellation', 'contractor_discharge'])->nullable();
            $table->text('cancel_remarks')->nullable();
            $table->enum('is_refund', ['Yes', 'No'])->default('Yes');
            $table->unsignedDecimal('refund_amount', 18, 0)->nullable();
            $table->text('refund_remarks')->nullable();

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
        Schema::dropIfExists('cancelled_bonds');
    }
};
