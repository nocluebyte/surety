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
        Schema::create('cases_decisions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proposal_id')->nullable();
            $table->unsignedBigInteger('cases_id')->nullable();
            $table->unsignedBigInteger('contractor_id')->nullable();
            $table->string('project_acceptable')->nullable();
            $table->longText('project_acceptable_remark')->nullable();
            $table->unsignedBigInteger('bond_type_id')->nullable();
            $table->unsignedDecimal('bond_value',18,0);
            $table->date('bond_start_date')->nullable();
            $table->date('bond_end_date')->nullable();
            $table->string('decision_status')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('cases_decisions');
    }
};
