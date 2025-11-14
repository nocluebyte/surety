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
        Schema::create('proposal_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('proposal_id')->nullable();
            $table->string('new_status',100)->nullable();
            $table->string('current_status',100)->nullable();
            $table->longText('remarks')->nullable();
            $table->integer('tender_evaluation_id')->nullable();
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
        Schema::dropIfExists('proposal_logs');
    }
};
