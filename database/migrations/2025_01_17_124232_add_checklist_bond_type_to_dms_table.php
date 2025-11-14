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
        Schema::table('dms', function (Blueprint $table) {
            $table->string('checklist_bond_type')->nullable()->after('final_submission');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dms', function (Blueprint $table) {
            $table->dropColumn('checklist_bond_type');
        });
    }
};
