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
        Schema::table('management_profiles', function (Blueprint $table) {
            $table->unsignedBigInteger('contractor_fetch_reference_id')->nullable()->after('managementprofilesable_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('management_profiles', function (Blueprint $table) {
            $table->dropColumn('contractor_fetch_reference_id');
        });
    }
};
