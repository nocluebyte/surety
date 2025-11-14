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
        Schema::create('management_profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('proposal_id')->default(0);
            $table->integer('designation')->default(0);
            $table->string('name')->nullable();
            $table->string('qualifications')->nullable();
            $table->string('experience')->nullable();
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
        Schema::dropIfExists('management_profiles');
    }
};
