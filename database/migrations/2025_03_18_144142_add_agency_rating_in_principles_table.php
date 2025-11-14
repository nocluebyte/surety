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
            $table->unsignedBigInteger('agency_id')->nullable()->after('status');
            $table->unsignedBigInteger('agency_rating_id')->nullable()->after('agency_id');
            $table->text('rating_remarks')->nullable()->after('agency_rating_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('principles', function (Blueprint $table) {
            $table->dropColumn(['agency_id', 'agency_rating_id', 'rating_remarks']);
        });
    }
};
