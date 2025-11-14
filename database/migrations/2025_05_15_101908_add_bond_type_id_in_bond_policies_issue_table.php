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
        Schema::table('bond_policies_issue', function (Blueprint $table) {
            $table->unsignedBigInteger('bond_type_id')->nullable()->after('bond_conditionality');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bond_policies_issue', function (Blueprint $table) {
            $table->dropColumn('bond_type_id');
        });
    }
};
