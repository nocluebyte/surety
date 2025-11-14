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
        Schema::table('proposal_logs', function (Blueprint $table) {
            $table->unsignedInteger('rejection_reason')->nullable()->after('current_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proposal_logs', function (Blueprint $table) {
            $table->dropColumn('rejection_reason');
        });
    }
};
