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
        Schema::create('performance_bond_beneficiaries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('performance_bond_id')->default(0);
            $table->integer('performance_beneficiary_id')->default(0);
            $table->enum('performance_beneficiary_type', ['Public', 'Private'])->default('Public');
            $table->integer('establishment_type')->default(0);
            $table->integer('type_of_beneficiary_entity')->default(0);
            $table->integer('misitry_type')->default(0);
            $table->integer('project_type')->default(0);
            $table->string('project_horizon')->nullable();
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
        Schema::dropIfExists('performance_bond_beneficiaries');
    }
};
