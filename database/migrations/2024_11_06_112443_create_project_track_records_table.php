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
        Schema::create('project_track_records', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('proposal_id')->default(0);
            $table->string('project_name')->nullable();
            $table->text('description')->nullable();
            $table->integer('project_cost')->default(0);
            $table->integer('project_tenor')->default(0);
            $table->date('project_start_date')->nullable();
            $table->string('principal_name')->nullable();
            $table->date('estimated_date_of_completion')->nullable();
            $table->integer('type_of_project_track')->default(0);
            $table->integer('project_share_track')->default(0);
            $table->date('actual_date_completion')->nullable();
            $table->integer('amount_margin')->default(0);
            $table->string('completion_status')->nullable();
            $table->integer('bg_amount')->default(0);
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
        Schema::dropIfExists('project_track_records');
    }
};
