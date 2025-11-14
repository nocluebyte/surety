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
        Schema::table('nbi_logs', function (Blueprint $table) {
            $table->unsignedBigInteger('bond_id')->nullable()->after('proposal_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nbi_logs', function (Blueprint $table) {
            $table->dropColumn('bond_id');
        });
    }
};
