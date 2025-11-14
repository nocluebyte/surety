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
        Schema::create('maintenance_bond_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('maintenance_bond_id')->nullable();
            $table->unsignedBigInteger('parent_maintenance_bond_id')->nullable();
            $table->longText('field_name')->nullable();
            $table->longText('old_value')->nullable();
            $table->longText('new_value')->nullable();
            $table->unsignedBigInteger('maintenance_bond_version')->nullable();

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
        Schema::dropIfExists('maintenance_bond_logs');
    }
};
