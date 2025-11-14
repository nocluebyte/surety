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
        Schema::table('cases_bond_limit_strategies', function (Blueprint $table) {
            $table->unsignedDecimal('bond_utilized_cap_persontage')->nullable()->after('bond_utilized_cap');
            $table->unsignedDecimal('bond_remaining_cap_persontage')->nullable()->after('bond_remaining_cap');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cases_bond_limit_strategies', function (Blueprint $table) {
            $table->dropColumn([
                'bond_utilized_cap_persontage',
                'bond_remaining_cap_persontage'
            ]);
        });
    }
};
