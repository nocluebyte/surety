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
        Schema::table('proposals', function (Blueprint $table) {
            $table->string('bond_period_year')->nullable()->after('bond_period');
            $table->string('bond_period_month')->nullable()->after('bond_period_year');
            $table->string('bond_period_days')->nullable()->after('bond_period_month');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proposals', function (Blueprint $table) {
            $table->dropColumn(['bond_period_year','bond_period_month','bond_period_days']);
        });
    }
};
