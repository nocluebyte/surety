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
        Schema::create('agency_rating_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('agencyratingdetailsable_type')->nullable();
            $table->unsignedBigInteger('agencyratingdetailsable_id')->nullable();
            $table->unsignedBigInteger('rating_id')->nullable();
            $table->string('rating')->nullable();
            $table->text('remarks')->nullable();
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
        Schema::dropIfExists('agency_rating_details');
    }
};
