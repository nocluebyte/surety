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
        Schema::create('bid_completed_projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('bid_bond_id')->default(0);
            $table->string('project_name')->nullable();
            $table->string('location')->nullable();
            $table->decimal('project_cost', 18, 0)->default(0);
            $table->string('project_period')->nullable();
            $table->string('status')->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('bid_completed_projects');
    }
};
