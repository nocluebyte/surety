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
            $table->string('decision_status')->nullable()->after('value');
            $table->date('bond_end_date')->after('decision_status')->nullable();
            $table->tinyInteger('is_last_of_approved')->after('bond_end_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('utilized_limit_strategys', function (Blueprint $table) {
            $table->dropColumn([
                'decision_status',
                'bond_end_date',
                'is_last_of_approved'
            ]);
        });
    }
};
