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
        Schema::table('cases', function (Blueprint $table) {
            $table->string('decision_status')->nullable()->after('status');
            $table->date('decision_taken_date')->nullable()->after('last_bs_date');
            $table->date('decision_draft_taken_date')->nullable()->after('decision_taken_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cases', function (Blueprint $table) {
            $table->dropColumn([
                'decision_status',
                'decision_taken_date',
                'decision_draft_taken_date'
            ]);
        });
    }
};
