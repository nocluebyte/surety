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
        Schema::create('advance_payment_financing_arrangements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('advance_payment_bond_id')->nullable();
            $table->unsignedBigInteger('facility_type_id')->nullable();
            $table->string('bank_fi')->nullable();
            $table->unsignedDecimal('approved_amount', 18, 0)->nullable();
            $table->unsignedDecimal('amount_utilised', 18, 0)->nullable();
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
        Schema::dropIfExists('advance_payment_financing_arrangements');
    }
};
