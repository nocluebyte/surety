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
        Schema::table('principles', function (Blueprint $table) {
            $table->date('last_balance_sheet_date')->nullable()->after('contractor_rating_date');
            $table->date('last_analysis_date')->nullable()->after('last_balance_sheet_date');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('principles', function (Blueprint $table) {
            $table->dropColumn([
                'last_balance_sheet_date',
                'last_analysis_date'
            ]);
        });
    }
};
