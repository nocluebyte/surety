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
        Schema::create('letter_of_awards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('parent_contractor_id')->nullable();
            $table->unsignedBigInteger('contractor_id')->nullable();
            $table->string('ref_no_loa')->nullable();

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
        Schema::dropIfExists('letter_of_awards');
    }
};
