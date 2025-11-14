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
        Schema::table('cases', function (Blueprint $table) {
            $table->string('casesable_type')->nullable()->change();
            $table->unsignedBigInteger('casesable_id')->nullable()->change();
            $table->unsignedBigInteger('contractor_id')->nullable()->change();
            $table->unsignedBigInteger('beneficiary_id')->nullable()->change();
            $table->unsignedBigInteger('proposal_id')->nullable()->change();
            $table->unsignedBigInteger('tender_id')->nullable()->change();
            $table->unsignedBigInteger('bond_type_id')->nullable()->change();
            $table->unsignedDecimal('bond_value', 18, 0)->nullable()->change();
            $table->unsignedDecimal('contract_value', 18, 0)->nullable()->change();
            $table->longText('project_details_any_updates')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cases', function (Blueprint $table) {
            $table->string('casesable_type')->change();
            $table->unsignedBigInteger('casesable_id')->change();
            $table->integer('contractor_id')->nullable()->change();
            $table->integer('beneficiary_id')->nullable()->change();
            $table->integer('proposal_id')->nullable()->change();
            $table->integer('tender_id')->nullable()->change();
            $table->integer('bond_type_id')->nullable()->change();
            $table->integer('bond_value')->nullable()->change();
            $table->integer('contract_value')->nullable()->change();
            $table->longText('project_details_any_updates')->change();
        });
    }
};
