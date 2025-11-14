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
        Schema::table('tenders', function (Blueprint $table) {
            $table->string('tender_reference_no')->nullable()->after('tender_id');
            $table->integer('beneficiary_id')->default(0)->after('last_name');

            $table->dropColumn('company_name');

            $table->after('period_of_contract', function (Blueprint $table) {
                $table->decimal('bond_value', 18, 0)->default(0);
                $table->integer('bond_type_id')->default(0);
                $table->date('bond_start_date')->nullable();
                $table->date('bond_end_date')->nullable();
                $table->integer('period_of_bond')->default(0);
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tenders', function (Blueprint $table) {
            $table->dropColumn('tender_reference_no');
            $table->dropColumn('beneficiary_id');
            $table->dropColumn('bond_value');
            $table->dropColumn('bond_type_id');
            $table->dropColumn('bond_start_date');
            $table->dropColumn('bond_end_date');
            $table->dropColumn('period_of_bond');

            $table->string('company_name')->nullable()->after('last_name');
        });
    }
};
