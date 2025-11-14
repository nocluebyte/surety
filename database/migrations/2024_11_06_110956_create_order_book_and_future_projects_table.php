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
        Schema::create('order_book_and_future_projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('proposal_id')->default(0);
            $table->text('project_scope')->nullable();
            $table->string('principal_name')->nullable();
            $table->string('project_location')->nullable();
            $table->integer('type_of_project')->default(0);
            $table->integer('contract_value')->default(0);
            $table->date('anticipated_date')->nullable();
            $table->integer('tenure')->default(0);
            $table->integer('project_share')->default(0);
            $table->integer('guarantee_amount')->default(0);
            $table->string('current_status')->nullable();
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
        Schema::dropIfExists('order_book_and_future_projects');
    }
};
