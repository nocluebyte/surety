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
        Schema::table('beneficiaries', function (Blueprint $table) {
            $table->dropColumn(['first_name', 'middle_name', 'last_name']);

            $table->after('company_name', function (Blueprint $table) {
                $table->string('company_code')->nullable();
                $table->string('reference_code')->nullable();
            });

            $table->after('establishment_type_id', function (Blueprint $table) {
                $table->text('bond_wording')->nullable();
                $table->integer('trade_sector_id')->default(0);
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('beneficiaries', function (Blueprint $table) {
            $table->dropColumn('company_code');
            $table->dropColumn('reference_code');
            $table->dropColumn('bond_wording');
            $table->dropColumn('trade_sector_id');

            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
        });
    }
};
