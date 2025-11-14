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
        Schema::table('utilized_limit_strategys', function (Blueprint $table) {
            $table->tinyInteger('is_current')->nullable()->after('is_amend');
            $table->renameColumn('is_amend','is_amendment');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('utilized_limit_strategys', function (Blueprint $table) {
            $table->dropColumn('is_current');
            $table->renameColumn('is_amendment','is_amend');
        });
    }
};
