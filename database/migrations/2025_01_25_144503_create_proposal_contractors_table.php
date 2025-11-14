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
        Schema::create('proposal_contractors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('proposal_id')->nullable();
            $table->string('proposal_contractor_type')->nullable();
            $table->integer('proposal_contractor_id')->nullable();
            $table->string('pan_no')->nullable();
            $table->unsignedDecimal('overall_cap', 18, 0)->nullable();
            $table->unsignedDecimal('spare_capacity', 18, 0)->nullable();
            $table->integer('jv_spv_exposure')->nullable();
            $table->integer('assign_exposure')->nullable();
            $table->unsignedDecimal('consumed', 18, 0)->nullable();
            $table->unsignedDecimal('remaining_cap', 18, 0)->nullable();
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
        Schema::dropIfExists('proposal_contractors');
    }
};
