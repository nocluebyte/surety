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
        Schema::create('utilized_limit_strategys', function (Blueprint $table) {
            $table->id();
            $table->morphs('strategyable');
            $table->unsignedBigInteger('contractor_id')->nullable();
            $table->string('proposal_code')->nullable();
            $table->unsignedBigInteger('cases_action_plan_id')->nullable();
            $table->unsignedBigInteger('cases_id')->nullable();
            $table->unsignedBigInteger('cases_decisions_id')->nullable();
            $table->unsignedDouble('value',18,0)->nullable();
            $table->unsignedBigInteger('is_amend')->nullable();
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
        Schema::dropIfExists('utilized_limit_strategys');
    }
};
