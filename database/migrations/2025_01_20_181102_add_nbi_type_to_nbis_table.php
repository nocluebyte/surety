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
            $table->string('nbi_type')->default('Proposal')->after('policy_no')->nullable();
            $table->integer('bond_id')->after('proposal_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nbis', function (Blueprint $table) {
            $table->dropColumn('nbi_type');
            $table->dropColumn('bond_id');
        });
    }
};
