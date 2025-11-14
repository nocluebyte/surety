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
        Schema::create('tender_evaluations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('proposal_id');
            $table->unsignedBigInteger('contractor_id');
            $table->longText('rating_score')->nullable();
            $table->LongText('tender_id')->nullable();
            $table->LongText('project_description')->nullable();
            $table->unsignedBigInteger('beneficiary_id')->nullable();
            $table->string('project_value')->nullable();
            $table->string('bond_value')->nullable();
            $table->string('overall_capacity')->nullable();
            $table->string('individual_capacity')->nullable();
            $table->string('old_contract_running_contract')->nullable();
            $table->string('replacement_bg_for_existing_contract')->nullable();
            $table->string('experience_of_similar_contract_size')->nullable();
            $table->string('complexity_of_project_allowed')->nullable();
            $table->unsignedBigInteger('type_of_projects_allowed')->nullable();
            $table->string('type_of_bond_allowed')->nullable();
            $table->unsignedBigInteger('tenure_id')->nullable();
            $table->string('strategic_nature_of_the_project')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
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
        Schema::dropIfExists('tender_evaluations');
    }
};
