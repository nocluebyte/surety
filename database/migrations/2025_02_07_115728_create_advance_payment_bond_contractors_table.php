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
        Schema::create('advance_payment_bond_contractors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('advance_payment_bond_id')->nullable();
            $table->string('advance_payment_contractor_type')->nullable();
            $table->unsignedBigInteger('advance_payment_contractor_id')->nullable();
            $table->string('pan_no')->nullable();
            $table->unsignedDecimal('overall_cap', 18, 0)->default(0);
            $table->unsignedDecimal('spare_capacity', 18, 0)->default(0);
            $table->unsignedInteger('share_holding')->nullable();
            $table->unsignedInteger('jv_spv_exposure')->default(0);
            $table->unsignedInteger('assign_exposure')->default(0);
            $table->unsignedDecimal('consumed', 18, 0)->default(0);
            $table->unsignedDecimal('remaining_cap', 18, 0)->default(0);
            $table->unsignedTinyInteger('is_amendment')->default(0);

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
        Schema::dropIfExists('advance_payment_bond_contractors');
    }
};
