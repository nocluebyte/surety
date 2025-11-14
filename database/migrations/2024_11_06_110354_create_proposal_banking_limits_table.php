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
        Schema::create('proposal_banking_limits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('proposal_id')->default(0);
            $table->integer('banking_category_id')->default(0);
            $table->integer('facility_type_id')->default(0);
            $table->integer('sanctioned_amount')->default(0);
            $table->string('bank_name')->nullable();
            $table->date('latest_limit_utilized_date')->nullable();
            $table->integer('unutilized_limit')->default(0);
            $table->integer('commission_on_pg')->default(0);
            $table->integer('commission_on_fg')->default(0);
            $table->integer('margin_collateral')->default(0);
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
        Schema::dropIfExists('proposal_banking_limits');
    }
};
