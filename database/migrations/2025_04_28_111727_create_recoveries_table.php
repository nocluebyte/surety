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
        Schema::create('recoveries', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            // $table->unsignedBigInteger('contractor_id')->nullable();
            $table->unsignedBigInteger('invocation_notification_id')->nullable();
            $table->string('invocation_number')->nullable();
            $table->unsignedDecimal('bond_value',18,0)->nullable();
            $table->unsignedDecimal('total_approved_bond_value',18,0)->nullable();
            $table->unsignedDecimal('claimed_amount',18,0)->nullable();
            $table->unsignedDecimal('disallowed_amount',18,0)->nullable();
            $table->text('invocation_remark')->nullable();
            $table->date('recover_date')->nullable();
            $table->unsignedDecimal('recover_amount',18,0)->nullable();
            $table->unsignedDecimal('outstanding_amount',18,0)->nullable();
            $table->text('remark')->nullable();
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
        Schema::dropIfExists('recoveries');
    }
};
