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
        Schema::create('bond_closures', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('bond_id')->nullable();
            $table->string('bond_type')->nullable();
            $table->enum('bond_status', ['bond_cancellation', 'closure', 'expiry'])->nullable();
            $table->enum('bond_cancellation_type', ['pre_project', 'mid_project'])->nullable();
            $table->enum('closure_type', ['short_closure', 'foreclosure', 'early_completion'])->nullable();
            $table->enum('expiry_type', ['expiry_completion', 'expired_shift'])->nullable();
            $table->text('closure_remarks')->nullable();
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
        Schema::dropIfExists('bond_closures');
    }
};
