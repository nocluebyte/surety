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
        Schema::create('cases_action_plans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('cases_id')->nullable();
            $table->longtext('reason_for_submission')->nullable();
            $table->enum('adverse_notification',['Yes','No'])->default('No');
            $table->longtext('adverse_notification_remark')->nullable();
            $table->string('audited')->nullable();
            $table->string('consolidated')->nullable();
            $table->integer('currency_id')->nullable();
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
        Schema::dropIfExists('cases_action_plans');
    }
};
