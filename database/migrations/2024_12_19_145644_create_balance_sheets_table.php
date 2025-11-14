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
        Schema::create('balance_sheets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->morphs('casesable');
            $table->unsignedBigInteger('cases_action_plan_id')->nullable();
            $table->unsignedBigInteger('cases_id')->nullable();
            $table->longText('cash')->nullable();
            $table->longText('tdrs')->nullable();
            $table->longText('quick')->nullable();
            $table->longText('stock')->nullable();
            $table->longText('other_ca')->nullable();
            $table->longText('total_ca')->nullable();
            $table->longText('fixed_assets')->nullable();
            $table->longText('intangible')->nullable();
            $table->longText('other_fa')->nullable();
            $table->longText('total_fa')->nullable();
            $table->longText('total_bs_a')->nullable();
            $table->longText('std')->nullable();
            $table->longText('tr_crs')->nullable();
            $table->longText('other_cl')->nullable();
            $table->longText('total_cl')->nullable();
            $table->longText('long_term')->nullable();
            $table->longText('provision')->nullable();
            $table->longText('total_ltd')->nullable();
            $table->longText('equity')->nullable();
            $table->longText('retained')->nullable();
            $table->longText('net_worth')->nullable();
            $table->longText('total_bs_b')->nullable();
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
        Schema::dropIfExists('balance_sheets');
    }
};
