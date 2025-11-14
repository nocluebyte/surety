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
        Schema::create('bid_financing_arrangements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('bid_bond_id')->default(0);
            $table->integer('facility_type_id')->default(0);
            $table->string('bank_fi')->nullable();
            $table->decimal('approved_amount', 18, 0)->default(0);
            $table->decimal('amount_utilised', 18, 0)->default(0);
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
        Schema::dropIfExists('bid_financing_arrangements');
    }
};
