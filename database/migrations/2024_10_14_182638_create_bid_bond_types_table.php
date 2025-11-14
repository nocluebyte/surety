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
        Schema::create('bid_bond_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('bid_bond_id')->default(0);
            $table->string('bid_bond_type')->nullable();
            $table->integer('bond_id')->default(0);
            $table->tinyInteger('is_other')->default(0);
            $table->text('other_description')->nullable();
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
        Schema::dropIfExists('bid_bond_types');
    }
};
