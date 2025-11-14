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
        Schema::create('performance_bond_contractors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('performance_bond_id')->default(0);
            $table->string('performance_contractor_type')->nullable();
            $table->integer('performance_contractor_id')->default(0);
            $table->string('pan_no')->nullable();
            $table->unsignedDecimal('overall_cap', 18, 0)->default(0);
            $table->unsignedDecimal('spare_capacity', 18, 0)->default(0);
            $table->integer('jv_spv_exposure')->default(0);
            $table->integer('assign_exposure')->default(0);
            $table->unsignedDecimal('consumed', 18, 0)->default(0);
            $table->unsignedDecimal('remaining_cap', 18, 0)->default(0);            
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
        Schema::dropIfExists('performance_bond_contractors');
    }
};
