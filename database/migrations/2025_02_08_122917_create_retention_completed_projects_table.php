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
        Schema::create('retention_completed_projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('retention_bond_id')->nullable();
            $table->string('project_name')->nullable();
            $table->string('location')->nullable();
            $table->unsignedDecimal('project_cost', 18, 0)->nullable();
            $table->string('project_period')->nullable();
            $table->string('status')->nullable();
            $table->text('description')->nullable();
            $table->unsignedTinyInteger('is_amendment')->default(0);

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
        Schema::dropIfExists('retention_completed_projects');
    }
};
