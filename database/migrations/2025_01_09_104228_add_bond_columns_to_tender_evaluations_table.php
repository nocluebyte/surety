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
        Schema::table('tender_evaluations', function (Blueprint $table) {
            $table->date('bond_start_date')->nullable()->after('bond_value');
            $table->date('bond_end_date')->nullable()->after('bond_start_date');
            $table->unsignedBigInteger('bond_period')->nullable()->after('bond_end_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tender_evaluations', function (Blueprint $table) {
            $table->dropColumn(['bond_start_date','bond_end_date','bond_period']);
        });
    }
};
