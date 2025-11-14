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
            $table->after('special_condition', function (Blueprint $table) {
                $table->date('premium_date')->nullable();
                $table->decimal('premium_amount', 18, 0)->default(0);
                $table->decimal('additional_premium', 18, 0)->default(0);
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bond_policies_issue', function (Blueprint $table) {
            $table->dropColumn('premium_date');
            $table->dropColumn('premium_amount');
            $table->dropColumn('additional_premium');
        });
    }
};
