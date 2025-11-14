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
        Schema::create('ratios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->morphs('casesable');
            $table->unsignedBigInteger('cases_action_plan_id')->nullable();
            $table->unsignedBigInteger('cases_id')->nullable();
            $table->longText('gp')->nullable();
            $table->longText('ebidta')->nullable();
            $table->longText('bt')->nullable();
            $table->longText('icr')->nullable();
            $table->longText('drs')->nullable();
            $table->longText('crs')->nullable();
            $table->longText('stock_turnover')->nullable();
            $table->longText('credity_cycle')->nullable();
            $table->longText('term_gearing')->nullable();
            $table->longText('total_gearing')->nullable();
            $table->longText('solvability')->nullable();
            $table->longText('c_ratio')->nullable();
            $table->longText('quick_ratio')->nullable();
            $table->longText('working_capital')->nullable();
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
        Schema::dropIfExists('ratios');
    }
};
