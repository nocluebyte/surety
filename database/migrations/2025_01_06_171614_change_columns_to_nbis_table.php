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
        Schema::table('nbis', function (Blueprint $table) {
            $table->decimal('contract_value',18,0)->change();
            $table->decimal('bond_value',18,0)->change();
            $table->decimal('bond_period_days',18,0)->change();
            $table->decimal('net_premium',18,0)->change();
            $table->decimal('stamp_duty_charges',18,0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nbis', function (Blueprint $table) {
            //
        });
    }
};
