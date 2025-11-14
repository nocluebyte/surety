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
        Schema::table('project_track_records', function (Blueprint $table) {
            $table->unsignedBigInteger('contractor_fetch_reference_id')->nullable()->after('projecttrackrecordsable_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project_track_records', function (Blueprint $table) {
            $table->dropColumn('contractor_fetch_reference_id');
        });
    }
};
