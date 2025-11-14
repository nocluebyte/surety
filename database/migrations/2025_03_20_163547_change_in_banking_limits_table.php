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
            $table->text('other_banking_details')->nullable()->after('margin_collateral');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('banking_limits', function (Blueprint $table) {
            $table->dropColumn('other_banking_details');
        });
    }
};
