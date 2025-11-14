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
        Schema::rename('principle_trade_sectors','trade_sector_items');
        Schema::table('trade_sector_items', function (Blueprint $table) {
            $table->renameColumn('principle_id','tradesectoritemsable_id');
            $table->string('tradesectoritemsable_type')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trade_sectors', function (Blueprint $table) {
            //
        });
    }
};
