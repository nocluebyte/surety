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
        Schema::create('cases_limit_strategys', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->morphs('casesable');
            $table->unsignedBigInteger('cases_action_plan_id')->nullable();
            $table->unsignedBigInteger('cases_id')->nullable();
            $table->unsignedDecimal('proposed_individual_cap',18,0)->nullable();
            $table->double('proposed_overall_cap',18,0)->nullable();
            $table->double('proposed_valid_till',18,0)->nullable();
            $table->double('proposed_group_cap',18,0)->nullable();
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
        Schema::dropIfExists('cases_limit_strategys');
    }
};
