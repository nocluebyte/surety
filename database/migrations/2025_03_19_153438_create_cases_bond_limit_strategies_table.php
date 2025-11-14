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
        Schema::create('cases_bond_limit_strategies', function (Blueprint $table) {
            $table->id();
            $table->morphs('casesable');
            $table->unsignedBigInteger('cases_action_plan_id')->nullable();
            $table->unsignedBigInteger('cases_id')->nullable();
            $table->unsignedBigInteger('bond_type_id')->nullable();
            $table->double('bond_current_cap',18,0)->nullable();
            $table->double('bond_utilized_cap',18,0)->nullable();
            $table->double('bond_remaining_cap',18,0)->nullable();
            $table->double('bond_proposed_cap',18,0)->nullable();
            $table->date('bond_valid_till')->nullable();
            $table->string('is_amend')->nullable();
            $table->string('status')->nullable();
            $table->integer('year_id')->nullable();
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
        Schema::dropIfExists('cases_bond_limit_strategies');
    }
};
