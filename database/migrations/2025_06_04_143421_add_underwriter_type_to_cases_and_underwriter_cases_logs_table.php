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
            $table->string('underwriter_type')->after('underwriter_id')->nullable();
        });

        Schema::table('underwriter_cases_logs', function (Blueprint $table) {
             $table->string('underwriter_type')->nullable()->after('underwriter_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cases', function (Blueprint $table) {
             $table->dropColumn('underwriter_type');
        });

        Schema::table('underwriter_cases_logs', function (Blueprint $table) {
            $table->dropColumn('underwriter_type');
        });
    }
};
