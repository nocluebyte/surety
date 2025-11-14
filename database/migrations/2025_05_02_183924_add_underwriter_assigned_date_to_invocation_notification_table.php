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
        Schema::table('invocation_notification', function (Blueprint $table) {
            $table->timestamp('underwriter_assigned_date')->nullable()->after('underwriter_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invocation_notification', function (Blueprint $table) {
            $table->dropColumn('underwriter_assigned_date');
        });
    }
};
