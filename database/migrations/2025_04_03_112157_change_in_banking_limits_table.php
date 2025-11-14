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
        Schema::table('banking_limits', function (Blueprint $table) {
            $table->dropColumn('latest_limit_utilized_date');
            $table->unsignedDecimal('latest_limit_utilized', 18, 0)->nullable()->after('bank_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('banking_limits', function (Blueprint $table) {
            $table->date('latest_limit_utilized_date')->nullable();
            $table->dropColumn('latest_limit_utilized');
        });
    }
};
