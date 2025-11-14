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
        Schema::create('invocation_notification', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('bond_id')->default(0);
            $table->string('bond_type')->nullable();
            $table->date('invocation_date')->nullable();
            $table->integer('invocation_amount')->default(0);
            $table->enum('invocation_ext', ['Yes', 'No'])->default('Yes')->nullable();
            $table->string('officer_name')->nullable();
            $table->string('officer_designation')->nullable();
            $table->string('officer_email')->nullable();
            $table->string('officer_mobile')->nullable();
            $table->string('officer_land_line')->nullable();
            $table->string('incharge_name')->nullable();
            $table->string('incharge_designation')->nullable();
            $table->string('incharge_email')->nullable();
            $table->string('incharge_mobile')->nullable();
            $table->string('incharge_land_line')->nullable();
            $table->string('office_branch')->nullable();
            $table->text('office_address')->nullable();
            $table->text('reason')->nullable();
            $table->text('remark')->nullable();
            $table->string('closed_reason')->nullable();
            $table->tinyInteger('is_amendment')->default(0)->nullable();
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
        Schema::dropIfExists('invocation_notification');
    }
};
