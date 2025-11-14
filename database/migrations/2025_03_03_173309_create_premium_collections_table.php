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
        Schema::create('premium_collections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('bond_id')->nullable();
            $table->string('bond_type')->nullable();
            $table->unsignedBigInteger('tender_id')->nullable();
            $table->unsignedBigInteger('beneficiary_id')->nullable();
            $table->unsignedDecimal('bond_value', 18, 0)->nullable();
            $table->unsignedDecimal('payment_received', 18, 0)->nullable();
            $table->date('payment_received_date')->nullable();
            $table->text('remarks')->nullable();
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
        Schema::dropIfExists('premium_collections');
    }
};
