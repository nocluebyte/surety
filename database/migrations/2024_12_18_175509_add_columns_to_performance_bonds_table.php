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
        Schema::table('performance_bonds', function (Blueprint $table) {
            $table->string('source')->nullable()->after('id');
            $table->integer('source_id')->nullable()->after('source');
            $table->string('contract_type')->nullable()->after('source_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('performance_bonds', function (Blueprint $table) {
            $table->dropColumn('source');
            $table->dropColumn('source_id');
            $table->dropColumn('contract_type');
        });
    }
};
