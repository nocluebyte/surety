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
            $table->dropColumn(['rating_date']);
        });

        Schema::table('proposals', function (Blueprint $table) {
            $table->dropColumn(['rating_date']);
        });

        Schema::table('agency_rating_details', function (Blueprint $table) {
            $table->date('rating_date')->nullable()->after('remarks');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('principles', function (Blueprint $table) {
            $table->date('rating_date')->nullable()->after('are_you_blacklisted');
        });

        Schema::table('proposals', function (Blueprint $table) {
            $table->date('rating_date')->nullable()->after('are_you_blacklisted');
        });

        Schema::table('agency_rating_details', function (Blueprint $table) {
            $table->dropColumn(['rating_date']);
        });
    }
};
