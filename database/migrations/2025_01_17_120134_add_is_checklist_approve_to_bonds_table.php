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
            $table->tinyInteger('is_checklist_approved')->default(0)->after('is_amendment');
        });
        Schema::table('performance_bonds', function (Blueprint $table) {
            $table->tinyInteger('is_checklist_approved')->default(0)->after('relevant_other_information');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bid_bonds', function (Blueprint $table) {
            $table->dropColumn('is_checklist_approved');
        });
        Schema::table('performance_bonds', function (Blueprint $table) {
            $table->dropColumn('is_checklist_approved');
        });
    }
};
