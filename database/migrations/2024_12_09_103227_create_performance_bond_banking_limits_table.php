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
        Schema::create('performance_bond_banking_limits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('performance_bond_id')->default(0);
            $table->integer('banking_category_id')->default(0);
            $table->integer('facility_type_id')->default(0);
            $table->string('sanctioned_amount')->nullable();
            $table->string('bank_name')->nullable();
            $table->date('latest_limit_utilized_date')->nullable();
            $table->string('unutilized_limit')->nullable();
            $table->string('commission_on_pg')->nullable();
            $table->string('commission_on_fg')->nullable();
            $table->string('margin_collateral')->nullable();
            $table->enum('is_active', ['Yes', 'No'])->default('Yes');
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
        Schema::dropIfExists('performance_bond_banking_limits');
    }
};
