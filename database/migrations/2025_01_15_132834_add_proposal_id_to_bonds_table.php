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
            $table->integer('proposal_id')->after('user_id')->nullable();
        });
        Schema::table('performance_bonds', function (Blueprint $table) {
            $table->integer('proposal_id')->after('source_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bid_bonds', function (Blueprint $table) {
            $table->dropColumn('proposal_id');
        });
        Schema::table('performance_bonds', function (Blueprint $table) {
            $table->dropColumn('proposal_id');
        });
    }
};
