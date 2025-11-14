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
            $table->string('source')->nullable()->after('version');
            $table->unsignedBigInteger('user_id')->nullable()->after('source');
            $table->dropColumn('bid_bond_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bid_bonds', function (Blueprint $table) {
            $table->dropColumn(['source', 'user_id']);
            $table->integer('bid_bond_id')->nullable();
        });
    }
};
