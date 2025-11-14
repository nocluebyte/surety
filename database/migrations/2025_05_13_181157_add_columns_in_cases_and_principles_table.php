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
            $table->string('contractor_rating')->nullable()->after('relevant_other_information');
            $table->unsignedBigInteger('uw_view_id')->nullable()->after('contractor_rating');
            $table->date('contractor_rating_date')->nullable()->after('uw_view_id');
        });

        Schema::table('cases', function (Blueprint $table) {
            $table->date('contractor_rating_date')->nullable()->after('uw_view_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('principles', function (Blueprint $table) {
            $table->dropColumn(['contractor_rating', 'uw_view_id', 'contractor_rating_date']);
        });

        Schema::table('cases', function (Blueprint $table) {
            $table->dropColumn('contractor_rating_date');
        });
    }
};
