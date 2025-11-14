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
        Schema::table('bid_bonds', function (Blueprint $table) {
            $table->integer('bid_bond_id')->default(0)->after('id');
            $table->date('bond_start_date')->nullable()->after('bond_issued');
            $table->date('bond_end_date')->nullable()->after('bond_start_date');
            $table->tinyInteger('is_amendment')->default(0)->after('bank_guarantees_details');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bid_bonds', function (Blueprint $table) {
            //
        });
    }
};
