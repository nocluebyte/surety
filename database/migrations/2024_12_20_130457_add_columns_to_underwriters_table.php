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
        Schema::table('underwriters', function (Blueprint $table) {
            $table->unsignedDecimal('approved_limit',18,0)->nullable()->after('user_id');
            $table->unsignedDecimal('individual_cap',18,0)->nullable()->after('approved_limit');
            $table->unsignedDecimal('overall_cap',18,0)->nullable()->after('individual_cap');
            $table->unsignedDecimal('group_cap',18,0)->nullable()->after('overall_cap');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('underwriters', function (Blueprint $table) {
            $table->dropColumn(['approved_limit','individual_cap','overall_cap','group_cap']);
        });
    }
};
