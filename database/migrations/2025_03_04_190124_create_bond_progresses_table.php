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
        Schema::create('bond_progresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('bond_id')->nullable();
            $table->unsignedBigInteger('version')->nullable();
            $table->string('bond_type')->nullable();
            $table->date('progress_date')->nullable();
            $table->text('progress_remarks')->nullable();
            $table->text('physical_completion_remarks')->nullable();
            $table->enum('dispute_initiated', ['Yes', 'No'])->default('Yes');
            $table->text('dispute_initiated_remarks')->nullable();
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
        Schema::dropIfExists('bond_progresses');
    }
};
